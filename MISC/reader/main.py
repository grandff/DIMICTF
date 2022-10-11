import sys

def send(data, end='\n'):   # end는 개행문자로
    sys.stdout.write(data + end)    # 개행문자가 포함이 안되어있음. 그래서 끝마다 end를 붙여놨음
    sys.stdout.flush()

def read():
    return raw_input()  # 파이썬 2버전에서만 사용하는 기능임

def filtering(filename):
    filter = ['flag', 'proc', 'self', 'etc', 'tmp', 'home', '~', '.', '*', '?', '\\', 'x'] # 이 키워드가 들어가면 필터링 처리
    for i in filter:
        if i in filename:
            send("Filtered!")
            sys.exit(-1)


if __name__ == '__main__':
    flag = open('flag', 'r')
    send("You can't read flag")
    send("But you can read file without filter XD")
    send("Filename :> ", end='')
    filename = read()
    filtering(filename)
    try:
        f = open(filename, 'r')
        send(f.read())
    except:
        send("No such file")
