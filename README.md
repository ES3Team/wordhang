[![CircleCI](https://circleci.com/gh/ES3Team/wordhang/tree/master.svg?style=svg)](https://circleci.com/gh/ES3Team/wordhang/tree/master)

#WordHang

Projeto com o intuito de criar um jogo da forca utilizando como metodologia o eXtreme Programming (XP), para cumprir as competências da disciplina ESIII - Faculdade Senac.

###Ferramentas

- PHP
- PHPUnit
- Symfony (Composer + Doctrine)
- Front (Bootstrap + jQuery)

###Montando o projeto

*Antes de começar, verifique se você possui o PHP, Symfony, Composer e MySQL instalados.*

- Utilizando um shell, entre na pasta do projeto clonado (git clone https://github.com/ES3Team/wordhang)
- Digite: ```composer install``` e espere pelo download das dependências. Quando exigido, pule as configurações do banco.
- Após a instalação completa, digite: ```php app/console doctrine:database:create```
- Logo após a criação do banco, digite: ```php app/console doctrine:schema:update --force```
- Pronto, o projeto está pronto para ser executado. Isto pode ser feito - dentro da pasta do mesmo - com o comando: ```php app/console server:run```

