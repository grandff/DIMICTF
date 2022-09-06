from sympy import Symbol, solve
import telnetlib
import socket

def main() :
    # tcp 방식으로 서버에 접속
    host = '192.168.161.128'    # ip는 vmware 구동시마다 바뀌므로 주의
    port = 8231
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)   # ipv4, tcp 사용
    s.connect((host, port))
    s.settimeout(5) # 5초간 사용하지 않으면 종료. 5초간 대기상태면 종료되기 때문에 반복문도 종료됨
    
    x = Symbol('x') # 미지수 설정. 방정식에서 사용되는 미지수로 활용
    equation = ""
    rData = ""
    
    while True :    # 일단 무한 반복으로 
        try :
            rData = s.recv(1024).decode()   # 최대 1024byte 단위로. decode는 기본적으로 UTF-8
        except socket.timeout:
            t = telnetlib.Telnet()
            t.sock = s
            t.interact()
            s.close()
            return 0;
        
        print(rData)    # return 받은 데이터 확인.
        if("No. " in rData) :   # 문제는 No. 로 시작함
            '''
            x=Symbol('x')
            x^3 - 5x^2 + 8x -4 = 0 <-- 이런식으로 문제를 받음
            곱하기가 없기 때문에 변환을 해줘야함
            파이썬의 경우 제곱은 ** 로 표현 가능
            위의 식은
            equation = "x**3 - 5*x**2 + 8*x - 4"
            '''
            rData = "".join(rData.split(" ")[2:-4]) # 배열로 나누고 join으로 다시 str로 가져옴
            rData = rData.replace("x", "*x")    # 위에서 말한 곱하기를 살려주는 작업
            equation = rData.replace("^", "**")
            print("[Parsed][ " + equation + " ]")
            
            ansArr = solve(equation) # solve에 넣으면 정답이 나옴
            lenArr = len(ansArr)    # 배열 형태로 리턴해주는데 경우의수를 따지기 위해 len으로 길이 확인
            rst = ""
            
            if(lenArr == 1) : # 중근인데 3중근
                rst = repr(ansArr[0]) + ", " + repr(ansArr[0]) + ", " + repr(ansArr[0]) + "\n"
                s.send(rst.encode())
                print("[Sended] " + rst)
                
            elif (lenArr == 2) : # 어느것이 중근인지 검증을 해야함
                prifix = int(equation.split("*x**3")[0])
                emt1 = ansArr[0]
                emt2 = ansArr[1]
                eCase1 = prifix*(x -1*emt1)**2 * (x -1*emt2)
                eCase2 = prifix*(x -1*emt2)**2 * (x -1*emt1)
                print(eCase1)
                print(eCase2)
                if (eCase1.equals(equation)):
                    rst = repr(emt1) + ", " + repr(emt1) + ", " + repr(emt2) + "\n" # repr -> 문자열 변환. solve로 받는 리턴값은 integer라서 문자열로 변환해줘야함.
                    s.send(rst.encode())
                    print("[Sended] " + rst)
                elif (eCase2.equals(equation)):
                    rst = repr(emt1) + ", " + repr(emt2) + ", " + repr(emt2) + "\n"
                    s.send(rst.encode())
                    print("[Sended] " + rst)
                else:
                    rst = repr(emt1) + ", " + repr(emt2) + "\n"
                    s.send(rst.encode())
                    print("[Sended] " + rst)
            elif (lenArr == 3): # 이건 그냥 그대로 설정하면 됨
                rst = repr(ansArr[0]) + ", " + repr(ansArr[1]) + ", " + repr(ansArr[2]) + "\n"
                s.send(rst.encode())
                print("[Sended] " + rst)

if __name__ == "__main__":
  main()                