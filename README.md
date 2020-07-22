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
