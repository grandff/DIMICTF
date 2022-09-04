from sympy import Symbol, solve
import telnetlib
import socket

def practice() :
    rData = "No. 1) 88x^3 - 12936x^2 + 496496x - 3759360 = 0 >> "
    print(rData.split(" "))
    print(rData.split(" ")[2:-4])   # = 0 >> 는 잘리게 됨 계산하기위해
    print("".join(rData.split(" ")[2:-4]))
    rData = "".join(rData.split(" ")[2:-4])
    rData = rData.replace("x", "*x")
    equation = rData.replace("^", "**")
    print(equation)

if __name__ == "__main__":
  practice()                