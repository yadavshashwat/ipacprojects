
var http = require('http');
var url = require('url');const crypto = require('crypto');
const HKDF = require('hkdf');
const atob = require('atob');
const btoa = require('btoa');
var fs = require('fs');
const request = require('request')


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

function hexToBytes(hexStr) {
  var intArray = [];
  for (var i = 0; i < hexStr.length; i += 2) {
    intArray.push(parseInt(hexStr.substr(i, 2), 16));
    }
  return new Uint8Array(intArray);
  }


function hexToBytes(hexStr){
  var intArray = [];
  for (var i = 0; i < hexStr.length; i+=2){
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

http.createServer(function (req, res) {
  var q = url.parse(req.url, true).query;
  console.log(q.mediakey.split(' ').join('+'));
  var mediaKeyBase64=q.mediakey.split(' ').join('+');
  var mediaKeyBytes = base64ToBytes(mediaKeyBase64);
  var link=q.media_url;
  var user=q.user_name;
  var caption=q.caption;
  var message_type=q.message_type;
  
  var dir="data/"+q.date;
  if (!fs.existsSync(dir)){
    fs.mkdirSync(dir);
}

  console.log(link)
  //   var link = "https://mmg-fna.whatsapp.net/d/f/Aj-HnHnXo1HJwCu-6mmTvgNU6R4u0A5YBr4uR9JuvWb4.enc"
  encodedFileHex = ''
  encodedFileBin = ''
  request(link, function () {
    // var mediaKeyBase64 = "QC6SZqOz+d5L6AYyoumUL1w6lhKwvNLmEbLrfdjmJjQ=";
    var mediaKeyBase64 = "gd5RDqKHBi846u5UA3I5hMjgy5ygwPw6+4RttFbGP+M=";
    var encodedFileHex = "15a15b57f8fe2cd238089b5d7cf021f3a870e70843b4267294e244d5868e14355810175c1657ff9e0d5b461a60c986a8bac76531566e7c46a986369f902ff695cd667294acb4dd7daf1f71b4f31444d1838c858ce0257f56c90ebf1b7ee9401d99c7f79c162b5a2eed4324b3d106dbfa99a3070c2c9e7a3b1f2e924b184e7c9557adc3a61b427963081b15a6146f13161cdd3d0aeccd58640fd3cd5f0fdfcc4f158ae8bdaf15e5587b5088bc6bec78091ebddae9ffcb651e3099102f9fd57ea9a88efc15547d49a9720c53fe839d11c4536c806c500462f4da53312ddd799c86f698f55d5330f1b8e344b4ba08193a052baf5d4092322a4c739b22dbe40103b286893c3d922c6b0e0dfdcb466ce6ecb3fc9b424eeed8e08ca01ec4f42515ecae6b99a7d69fdcac269c6e914268036bdb1e7623ae219b552a27e88be0eabaa532c0edbb222ecb186e8647";
    var mediaKeyBytes = base64ToBytes(mediaKeyBase64);
    console.log("encodedFileBin Length: " + "(" + encodedFileBin.length + " bytes)");
    var hkdf = new HKDF("sha256", new Uint8Array(32), mediaKeyBytes);
    hkdf.derive("WhatsApp Image Keys", 112, function (mediaKeyExpanded) {
    console.log("mediaKeyExpanded: " + mediaKeyExpanded.toString("hex") + " (" + mediaKeyExpanded.length + " bytes)");
    var iv = mediaKeyExpanded.slice(0, 16);
    var cipherKey = mediaKeyExpanded.slice(16, 48);
    // STEP 4: Download .enc file (already loaded in encodedBytes) and discard the last 10 bytes (mac is not needed for decoding)
    encodedBytes = hexToBytes(encodedFileHex).slice(0, -10);
    var decipher = crypto.createDecipheriv("aes-256-cbc", cipherKey, iv);
    var decoded_update = decipher.update(encodedBytes,'hex');
    decoded_update = decoded_update.toString("base64")
    var decoded = decipher.final("base64");
    console.log(message_type);
    if(message_type="image")
    {
      var extn=".png"
      var header='data:image/png;base64,'
    }
    if(message_type="video")
    {
      var extn=".mp4"
      var header='data:video/mp4;base64,'
    }    if(message_type="audio")
    {
      var extn=".ogg"
      var header='data:image/ogg;base64,'
    }
    var file_name=dir+"/"+user+","+caption+extn
    var decoded = header + btoa(atob(decoded_update) + atob(decoded));
    fs.writeFile(file_name,decodeBase64Image(decoded).data)
    res.end();
    });
  }).on('data', function(chunk){
    encodedFileBin += chunk.toString('binary');
    encodedFileHex += chunk.toString('hex');
  });
}).listen(8080);
