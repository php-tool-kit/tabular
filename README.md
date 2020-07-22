# ptk\tabular

**Ferramentas para trabalhar com dados tabulares, normalmente armazenados em array, complementando as funções para arrays do PHP.**

Este conjunto de ferramentas (a.k.a. biblioteca) tem o objetivo de prover alguns atalhos úteis para manipulação de arrays multidimensionais com dados organizados de forma tabular.

Dados tabulares (pelo menos para fins desta biblioteca) são aqueles organizados na forma de tabelas, com linhas e colunas. Um array tabular se parece com isso:

```php

$data = [
  [//linha 1
    'coluna1' => 1,
    'coluna2' => 'algum texto',
    'coluna3' => true
  ],
  [//linha 2
    'coluna1' => 2,
    'coluna2' => 'algum texto',
    'coluna3' => true
  ],
  [//linha 3
    'coluna1' => 3,
    'coluna2' => 'algum texto',
    'coluna3' => false
  ],
  [//linha 4
    'coluna1' => 4,
    'coluna2' => 'algum texto',
    'coluna3' => true
  ]
];

```

Adotei a estrutura *linha->coluna* em detrimento da estrutura *coluna->linha* porque parece que a primeira parece ser preferida pelo PHP em uma série de funções (como as relacionadas a banco de dados, por exemplo) e porque esse é a estrutura mais comum encontrado em outros códigos.

## Aviso importante

Não espere desempenho nem eficiência na alocação de recursos. Isso não é prioridade, pelo menos por enquanto.

## Exemplos

Você encontrará exemplos no diretório `examples`. Para cada função há um arquivo de exemplo de mesmo nome.

Tenha em mente que os exemplos foram projetados para serem executados via linha de comando a partir do diretório raiz do projeto. Então tente:

```sh
php examples/col_names.php
```

## Documentação

A documentação da biblioteca está no diretório `docs/html`.

## Changelog

O registro das alterações relevantes entre as versões está disponivel na descrição de cada [release](https://github.com/php-tool-kit/tabular/releases/).

## To-do

A lista de coisas a fazer pode ser encontrada nas [issues com a label todo](https://github.com/php-tool-kit/tabular/labels/todo).

## Contribuições

Contribuições sempre são bem vindas, entretanto para aumentar as velocidade de um *feedback* sobre elas, siga os seguintes passos:

1. Faça *fork* do projeto;
2. Crie um *branch* com um nome sugestivo para a sua contribuição;
3. Faça *pull request* das suas contribuições;

Se houver alguma [issue](https://github.com/php-tool-kit/tabular/issues) relacionada a sua contribuição, faça referência a ela.

Antes de fazer *push* para o *fork*, garanta um mínimo de qualidade, por favor execute os seguintes comandos personalizados do composer:

1. `composer test`
2. `composer stan`
3. `composer format`
4. `composer check`
5. `composer test`

Somente avance para o passo seguinte se o comando anterior estiver OK.

**É altamente recomendável que escreva testes cobrindo suas contribuições. Uma cobertura de código (*code coverage*) é altamente apreciada.**

**Não esqueça de incluir/atualizar a documentação do código de acordo com sua contribuição.** O [doxygen](https://www.doxygen.nl/) é utilizado para gerar a documentação de acordo com as configurações do `Doxyfile`. Gerar a documetnação não é requerido, mas caso deseje testar a documentação, use `doxygen` (desde que o Doxygen esteja instalado).