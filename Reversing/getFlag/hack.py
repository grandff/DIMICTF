# pip3 install pwntools
from pwn import *
import string
import time

def main() :
    table = string.ascii_letters + string.digits    # 서버와 똑같이 아스키코드와 숫자를 테이블로 사용함
    prifix = b"DIMI{"   
    potSaltIdx = "" # 노출되는 salt의 인덱스 수집
    potDec = ["-" for _ in range(0,40)] # 복호화된 플래그들의 문자열들을 수집해서 저장. 왜냐하면 바로 연결되어서 나오지 않고, 일정 간격을 두고 구할수 있어서..
    
    while(True) :
        time.sleep(0.1) # 일부러 딜레이를 줘서 중복연결이 안되도록 처리
        p = remote("192.168.161.128", 2842)
        
        p.recvline()        
        '''
        ex) salt[1]=H
        '''
        saltRaw = p.recvline().decode() # 받아오면 바이트타입이기 때문에 string으로 변환하기 위해 decode 사용
        saltIdx = int(saltRaw[5])   # 6번쨰에 salt의 index 값이 들어있음
        saltVal = saltRaw[-2]   # 개행문자가 있으므로 -2번째에 value 값이 들어있음
        
        '''
        ex) enc_data=~~~~~
        '''
        encRaw = p.recvline().decode()
        encVal = encRaw[9:-1]   # 좌측 값은 필요없기때문에 value만 받아옴. 마찬가지로 개행문자가 있음
        p.close()   # 연결 종료
        
        if (len(potSaltIdx) == 5) :
            print("".join(potDec))
            return 0
        
        if (repr(saltIdx) in potSaltIdx) :  # 중복된 인덱스가 있는지 확인(이미 받아왔으므로 필요없음)
            continue
        
        if(len(encVal) < 40):   # enc_data가 안들어올때를 대비해서 처리
            continue
        
        potSaltIdx += repr(saltIdx) # 현재 받은 인덱스를 string형으로 변환. 중복계산을 방지하기 위해
        print("[salt_indexs(all)] " + potSaltIdx)
        print("[salt_index] " + repr(saltIdx))
        print("[salt_value] " + saltVal)
        
        key1 = 0
        key2 = ord(encVal[saltIdx]) ^ ord(saltVal)
        for i in range(0, len(table)) :
            if (key2 ^ ord(table[i]) == prifix[saltIdx]) :
                key1 = ord(table[i])
                break
            
        for i in range(0, 40, 5) :
            potDec[saltIdx + i] = chr(ord(encVal[saltIdx+i]) ^ ord(saltVal) ^ key1)
            print(potDec)
            print()
            
if __name__ == "__main__" :
    main()
        