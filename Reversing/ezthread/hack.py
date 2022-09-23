import os

def main() :
    key1 = 0
    key2 = 0
    
    for key1 in range(0,128) :
        for key2 in range(0,128) :
            os.system("echo " + repr(key1) + " " + repr(key2) + " | .\ezthread.exe > flag.txt")
            f = open("flag.txt", "rb")
            flag = f.read()
            print("[key1] " + repr(key1) + " / [key2] " + repr(key2))
            if b"DIMI" in flag :
                print(flag)
                return 0
            f.close()

if __name__ == "__main__" :
    main()