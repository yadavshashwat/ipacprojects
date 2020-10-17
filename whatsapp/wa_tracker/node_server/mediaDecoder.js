const crypto = require('crypto');
const HKDF = require('hkdf');
const atob = require('atob');
const btoa = require('btoa');
const request = require('request')
const fs = require('fs');

function hexToBytes(hexStr) {
  var intArray = [];

  for (var i = 0; i < hexStr.length; i += 2) {
    intArray.push(parseInt(hexStr.substr(i, 2), 16));
  }
  
  return new Uint8Array(intArray);
}

function base64ToBytes(base64Str) {
  var binaryStr = atob(base64Str);
  var byteArray = new Uint8Array(binaryStr.length);

  for (var i = 0; i < binaryStr.length; i++) {
    byteArray[i] = binaryStr.charCodeAt(i);
  }
  
  return byteArray;
}

function decodeBase64Image(dataString) {
  var matches = dataString.match(/^data:([A-Za-z-+\/]+);base64,(.+)$/),
    response = {};

  if (matches.length !== 3) {
    return new Error('Invalid input string');
  }

  response.type = matches[1];
  response.data = new Buffer(matches[2], 'base64');

  return response;
}
///try these combination also
// https://mmg-fna.whatsapp.net/d/f/AmgQ3_1WvW5247FbeVmXtw-K3r5EkpGsyAeG6lys-8s2.enc
// IE8v4Qzb92MMkkWH867xoqw9riKj04k5hkM2VwUs1iE=


// https://mmg-fna.whatsapp.net/d/f/AlqMiZaXjqqUSOih9JAnmB__bmrqAWoLEWbxMSWLGcDu.enc
// hsKGIdyseE2G+EZS1KIZvnn0pxAZe4amWtF8vLWaFIE=
var link = "https://mmg-fna.whatsapp.net/d/f/AiOYH0fYp-QSl7t_uEZ-gudqQTUx0pinYGrSeilw3jXO.enc"
encodedFileHex = ''
encodedFileBin = ''
request(link, function () {
  var mediaKeyBase64 = "h9oFpSTzkzXfb+QOFzPi7+STaIed1ywQXHLIa5I1DSk=";
  var mediaKeyBytes = base64ToBytes(mediaKeyBase64);
  console.log("encodedFileBin Length: " + "(" + encodedFileBin.length + " bytes)");
  
  var hkdf = new HKDF("sha256", new Uint8Array(32), mediaKeyBytes);
  hkdf.derive("WhatsApp Image Keys", 112, function (mediaKeyExpanded) {
    console.log("mediaKeyExpanded: " + mediaKeyExpanded.toString("hex") + " (" + mediaKeyExpanded.length + " bytes)");
  
    // STEP 3: Split mediaKeyExpanded into iv and cipherKey (macKey and refKey are not needed for decoding)
  
    var iv = mediaKeyExpanded.slice(0, 16);
    var cipherKey = mediaKeyExpanded.slice(16, 48);
  
    console.log("iv: " + iv.toString("hex") + " (" + iv.length + " bytes)");
    console.log("cipherKey: " + cipherKey.toString("hex") + " (" + cipherKey.length + " bytes)");
  
    // STEP 4: Download .enc file (already loaded in encodedBytes) and discard the last 10 bytes (mac is not needed for decoding)
  
    encodedBytes = hexToBytes(encodedFileHex).slice(0, -10);
    // console.log("encoded Bytes: " + encodedBytes);
  
    // STEP 5: Validate media data. Skipping because it's not needed for decoding.
    // STEP 6: Decrypt file with AES-CBC using cipherKey and iv, and unpad it.
  
    var decipher = crypto.createDecipheriv("aes-256-cbc", cipherKey, iv);
    var decoded_update = decipher.update(encodedBytes,'hex');
    decoded_update = decoded_update.toString("base64")
    var decoded = decipher.final("base64");
    console.log(decoded_update.length)
    var decoded = 'data:image/png;base64,' + btoa(atob(decoded_update) + atob(decoded));
    fs.writeFile('test.png',decodeBase64Image(decoded).data)
  });
}).on('data', function(chunk){
  encodedFileBin += chunk.toString('binary');
  encodedFileHex += chunk.toString('hex');
});
