# uncompyle6 version 3.8.0
# Python bytecode 3.5 (3350)
# Decompiled from: Python 3.8.10 (default, Jun 22 2022, 20:18:18) 
# [GCC 9.4.0]
# Embedded file name: e.py
import sys, random, string, os, time

def send(data, end='\n'):
    sys.stdout.write(data + end)
    sys.stdout.flush()


def generateRandString(length, table=string.ascii_letters + string.digits):
    return ''.join([random.choice(table) for _ in range(length)])


def generateEncryptData():
    key1 = generateRandString(5) * 8
    salt = generateRandString(5) * 8
    offset = random.randrange(0, 5)
    flag = os.environ['flag']
    key2 = ''.join([chr(ord(key1[i]) ^ ord(flag[i])) for i in range(0, 40)])
    enc_data = ''.join([chr(ord(key2[i]) ^ ord(salt[i])) for i in range(0, 40)])
    send('salt[%d]=%c' % (offset, salt[offset]))
    send('enc_data=%s' % enc_data)


if __name__ == '__main__':
    random.seed(int(time.time()))
    send('You can calc flag?')
    generateEncryptData()