# 개요
## 설명
- 파일 업로드를 하는 웹시스템
- 이미지만 업로드 가능. 너무 큰 용량은 업로드 불가함.
- 쿠키값을 하나 저장하고 있음

## hint
확장자를 체크 하고 있으나 마지막 글자가 아닌 [1] 인덱스만 확인하고 있음. 확장자를 조작해서 업로드가 가능해보임.
php가 아닌 다른 확장자를 사용해서 쉘 명령어를 실행시킬 거임.

## exploit
php는 막혀있으나 확장자 뒤에 php와 비슷한 확장자를 쓸 수 있음. pht, phtml, phar 등이 있음.
hack.png.phtml을 업로드 하고 ?cmd=system("명령어") 를 통해 쉘 명령어 사용 가능.

> ?cmd=system("cat%20../../flaglfalllgllflflagflalglgllfllflflfaglflag");