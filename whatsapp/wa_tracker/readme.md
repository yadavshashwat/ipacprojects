## Running Custom client
Run whatsapp_web_backend.py and the wclient.py. copy the qr code paste it in browser. Run the nodejs server. Now scan the qr code

## Login and encryption details
WhatsApp Web encrypts the data using several different algorithms. These include [AES 256 CBC](https://en.wikipedia.org/wiki/Advanced_Encryption_Standard), [Curve25519](https://en.wikipedia.org/wiki/Curve25519) as Diffie-Hellman key agreement scheme, [HKDF](https://en.wikipedia.org/wiki/HKDF) for generating the extended shared secret and [HMAC](https://en.wikipedia.org/wiki/Hash-based_message_authentication_code) with SHA256.

Starting the WhatsApp Web session happens by just connecting to one of its websocket servers at `wss://w[1-8].web.whatsapp.com/ws` (`wss://` means that the websocket connection is secure; `w[1-8]` means that any number between 1 and 8 can follow the `w`). Also make sure that, when establishing the connection, the HTTP header `Origin: https://web.whatsapp.com` is set, otherwise the connection will be rejected.
### Messages
When you send messages to a WhatsApp Web websocket, they need to be in a specific format. It is quite simple and looks like `messageTag,JSON`, e.g. `1515590796,["data",123]`. Note that apparently the message tag can be anything. This application mostly uses the current timestamp as tag, just to be a bit unique. WhatsApp itself often uses message tags like `s1`, `1234.--0` or something like that. Obviously the message tag may not contain a comma. Additionally, JSON _objects_ are possible as well as payload.

### Logging in
To log in at an open websocket, follow these steps:

1. Generate your own `clientId`, which needs to be 16 base64-encoded bytes (i.e. 25 characters). This application just uses 16 random bytes, i.e. `base64.b64encode(os.urandom(16))` in Python.
2. Decide for a tag for your message, which is more or less arbitrary (see above). This application uses the current timestamp (in seconds) for that. Remember this tag for later.
3. The message you send to the websocket looks like this: `messageTag,["admin","init",[0,3,416],["Long browser description","ShortBrowserDesc"],"clientId",true]`.
	- Obviously, you need to replace `messageTag` and `clientId` by the values you chose before
	- The `[0,3,416]` part specifies the current WhatsApp Web version. The last value changes frequently. It should be quite backwards-compatible though.
	- `"Long browser description"` is an arbitrary string that will be shown in the WhatsApp app in the list of registered WhatsApp Web clients after you scan the QR code.
	- `"ShortBrowserDesc"` has not been observed anywhere yet but is arbitrary as well.
4. After a few moments, your websocket will receive a message in the specified format with the message tag _you chose in step 2_. The JSON object of this message has the following attributes:
	- `status`: should be 200
	- `ref`: in the application, this is treated as the server ID; important for the QR generation, see below
	- `ttl`: is 20000, maybe the time after the QR code becomes invalid
	- `update`: a boolean flag
	- `curr`: the current WhatsApp Web version, e.g. `0.2.7314`
	- `time`: the timestamp the server responded at, as floating-point milliseconds, e.g. `1515592039037.0`

### QR code generation
5. Generate your own private key with Curve25519, e.g. `curve25519.Private()`.
6. Get the public key from your private key, e.g. `privateKey.get_public()`.
7. Obtain the string later encoded by the QR code by concatenating the following values with a comma:
	- the server ID, i.e. the `ref` attribute from step 4
	- the base64-encoded version of your public key, i.e. `base64.b64encode(publicKey.serialize())`
	- your client ID
8. Turn this string into an image (e.g. using `pyqrcode`) and scan it using the WhatsApp app.

### Requesting new ref for QR code generation (not implemented)
9. You can request up to 5 new server refs when previous one expires (`ttl`).
10. Do it by sending `messageTag,["admin","Conn","reref"]`.
11. The server responds with JSON with the following attributes:
	- `status`: should be 200 (other ones: 304 - reuse previous ref, 429 - new ref denied)
	- `ref`: new ref
	- `ttl`: expiration time
12. Update your QR code with the new ref.

### After scanning the QR code
13. Immediately after you scan the QR code, the websocket receives several important JSON messages that build up the encryption details. These use the specified message format and have a JSON _array_ as payload. Their message tag has no special meaning. The first entry of the JSON array has one of the following values:
	- `Conn`: array contains JSON object as second element with connection information containing the following attributes and many more:
		- `battery`: the current battery percentage of your phone
		- `browserToken`: used to logout without active WebSocket connection (not implemented yet)
		- `clientToken`: used to resuming closed sessions aka "Remember me" (not implemented yet)
		- `phone`: an object with detailed information about your phone, e.g. `device_manufacturer`, `device_model`, `os_build_number`, `os_version`
		- `platform`: your phone OS, e.g. `android`
		- `pushname`: the name of yours you provided WhatsApp
		- `secret` (remember this!)
		- `serverToken`: used to resuming closed sessions aka "Remember me" (not implemented yet)
		- `wid`: your phone number in the chat identification format (see below)
	- `Stream`: array has four elements in total, so the entire payload is like `["Stream","update",false,"0.2.7314"]`
	- `Props`: array contains JSON object as second element with several properties like `imageMaxKBytes` (1024), `maxParticipants` (257), `videoMaxEdge` 
(960) and others
### Decryption of images
1. Obtain `mediaKey` and decode it from Base64 if necessary.
2. Expand it to 112 bytes using HKDF with type-specific application info (see below). Call this value `mediaKeyExpanded`.
3. Split `mediaKeyExpanded` into:
	- `iv`: `mediaKeyExpanded[:16]`
	- `cipherKey`: `mediaKeyExpanded[16:48]`
	- `macKey`: `mediaKeyExpanded[48:80]`
	- `refKey`: `mediaKeyExpanded[80:]` (not used)
4. Download media data from the `url` and split it into:
	- `file`: `mediaData[:-10]`
	- `mac`: `mediaData[-10:]`
5. Validate media data with HMAC by signing `iv + file` with `macKey` using SHA-256. Take in mind that `mac` is truncated to 10 bytes, so you should compare only the first 10 bytes.
6. Decrypt `file` with AES-CBC using `cipherKey` and `iv`, and unpad it. Note that this means that your session's keys (i.e. `encKey` and `macKey` from the _Key generation_ section) are not necessary to decrypt a media file.

### Application info for HKDF
Depending on the media type, the literal strings in the right column are the values for the `appInfo` parameter from the [`HKDF` function](https://github.com/sigalor/whatsapp-web-reveng/blob/master/backend/whatsapp.py#L37).

| Media Type | Application Info         |
| ---------- | ------------------------ |
| IMAGE      | `WhatsApp Image Keys`    |
| VIDEO      | `WhatsApp Video Keys`    |
| AUDIO      | `WhatsApp Audio Keys`    |
| DOCUMENT   | `WhatsApp Document Keys` |
