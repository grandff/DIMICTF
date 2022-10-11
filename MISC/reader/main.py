import sys

def send(data, end='\n'):
    sys.stdout.write(data + end)
    sys.stdout.flush()

def read():
    return raw_input()

def filtering(filename):
    filter = ['flag', 'proc', 'self', 'etc', 'tmp', 'home', '~', '.', '*', '?', '\\', 'x']
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
