1 Whatsapp blocking:
    1.1 Blocking login after repeated attempts
        a) Wait for one hour  : success
        b) Use anothe account : Limited success
    1.2 Whatsapp sending wrong .enc file after repeated attemps
        a) Download another .enc file :Failed
        b) Use another account        :Failed
        c) Use another account and system, preferably another network also: Yet to be done
2 Decrypting images:
    1.1 Error: error:0606506D:digital envelope routines:EVP_DecryptFinal_ex:wrong final        block length- decrytion of images fails at decipher.final() step
        a) Use another image: Failed
        b) Raised the issue in github(https://github.com/: No response yet
        sigalor/whatsapp-web-reveng/issues/86)
        c) Trying web client using go program : work in progress
3 Testing sending messages:
        a) Whatsapp blocked me