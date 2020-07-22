<?php

/**
 * Biblioteca para manipulação de dados tabulares, oferecendo funções
 *  complementares às funções de array da biblioteca padrão do PHP.
 *
 * Dados tabulares são arrays multidimensionais estruturados em linhas->colunas:
 *
 *  $data = [
 *      [//linha 1
 *          'coluna1' => 1,
 *          'coluna2' => 'algum texto',
 *          'coluna3' => true
 *      ],
 *      [//linha 2
 *          'coluna1' => 2,
 *          'coluna2' => 'algum texto',
 *          'coluna3' => true
 *      ],
 *      [//linha 3
 *          'coluna1' => 3,
 *          'coluna2' => 'algum texto',
 *          'coluna3' => false
 *      ]
 *
 */

namespace ptk\tabular;

use Exception;

use function count;

/**
 * Verifica se o array obedece a uma estrutura tabular.
 *
 * Verifica se em cada linha há o mesmo número de colunas com os mesmos rótulos.
 *
 * Se $check_types for true, também faz uma checagem de tipos em cada colunas
 *  para verificar se os dados são do mesmo tipo em cada coluna.
 *
 * @param array<array> $data
 * @param bool $check_types
 * @return bool
 * @throws Exception
 */
function check_structure(array $data, bool $check_types = true): bool
{

    $colnames = col_names($data);
    $base_numcols = count($colnames);
    foreach ($data as $line => $cols) {
        //testa o número de colunas
        $numcols = count($cols);
        if ($numcols !== $base_numcols) {
            throw new Exception("Número de colunas da linha $line é $numcols, no entanto deveria"
                . " ser $base_numcols.");
        }

        //testa os nomes de colunas
        if (array_keys($cols) !== $colnames) {
            throw new Exception(// @codeCoverageIgnoreStart
                sprintf(
                    'Eram esperadas as colunas %s, porém foram encontradas %s',
                    join(', ', $colnames),
                    join(', ', array_keys($cols))
                )
                // @codeCoverageIgnoreEnd
            );
        }
    }

    //checagem de tipos
    if ($check_types) {
        foreach ($colnames as $col) {
            $basetype = gettype($data[0][$col]);
            foreach ($data as $line => $cols) {
                $type = gettype($cols[$col]);
                if ($type !== $basetype) {
                    throw new Exception("O tipo esperado para a coluna $col era $basetype, porém"
                        . " na linha $line foi encontrado o tipo $type.");
                }
            }
        }
    }

    return true;
}

/**
 * Identifica os nomes de colunas.
 *
 * A identificação é feita a partir da primeira linha dos dados.
 *
 * @param array<array> $data
 * @return array<string>
 */
function col_names(array $data): array
{
    $first_line_key = array_key_first($data);
    return array_keys($data[$first_line_key]);
}

/**
 * Retorna os dados de todas as linhas das colunas selecionadas.
 *
 * @param array<array> $data
 * @param string $colnames
 * @return array<array>
 * @throws Exception
 */
function get_cols(array $data, string ...$colnames): array
{
    $result = [];
    $base_colnames = col_names($data);

    foreach ($colnames as $colname) {
        if (array_search($colname, $base_colnames) === false) {
            throw new Exception(
                //@codeCoverageIgnoreStart
                sprintf(
                    'A coluna %s não foi encontrada entre as colunas %s',
                    $colname,
                    join(', ', $base_colnames)
                )
                //@codeCoverageIgnoreEnd
            );
        }

        foreach ($data as $line => $cols) {
            $result[$line][$colname] = $cols[$colname];
        }
    }

    return $result;
}

/**
 * Retorna todas as linhas com as colunas entre $first e $last.
 *
 * @param array<array> $data
 * @param string $first Nome da primeira coluna do intervalo. Se omitido com uma string vazia, considera
 * a primeira coluna.
 * @param string $last Nome da última coluna do intervalo. Se omitido com uma string vazia, considera
 * a última coluna.
 * @return array<array>
 * @throws Exception
 */
function get_col_range(array $data, string $first = '', string $last = ''): array
{
    $result = [];
    $base_colnames = col_names($data);
    
    // configura os valores padrão
    if ($first === '') {
        $first = $base_colnames[array_key_first($base_colnames)];
    }
    
    if ($last === '') {
        $last = $base_colnames[array_key_last($base_colnames)];
    }

    //testa se as colunas existem
    $keyfirst = array_search($first, $base_colnames);
    $keylast = array_search($last, $base_colnames);
    if ($keyfirst === false) {
        throw new Exception(
            //@codeCoverageIgnoreStart
            sprintf(
                'A primeira coluna %s não foi encontrada entre as colunas %s',
                $first,
                join(', ', $base_colnames)
            )
            //@codeCoverageIgnoreEnd
        );
    }
    
    if ($keylast === false) {
        throw new Exception(
            //@codeCoverageIgnoreStart
            sprintf(
                'A última coluna %s não foi encontrada entre as colunas %s',
                $last,
                join(', ', $base_colnames)
            )
            //@codeCoverageIgnoreEnd
        );
    }
    
    // pega a lista de colunas do intervalo
    $listcols = [];
    for ($i = $keyfirst; $i <= $keylast; $i++) {
        $listcols[] = $base_colnames[$i];
    }
    
    //monta o resultado
    $result = get_cols($data, ...$listcols);
    
    return $result;
}

/**
 * Retorna um conjunto de linhas.
 *
 * As chaves de linhas serão reindexadas no resultado.
 *
 * @param array<array> $data
 * @param int $lines Uma lista de linhas para retornar.
 * @return array<array>
 * @throws Exception
 */
function get_lines(array $data, int ...$lines): array
{
    $result = [];
    
    foreach ($lines as $index) {
        if (!key_exists($index, $data)) {
            throw new Exception("A linha $index não foi encontrada.");
        }
        
        $result[] = $data[$index];
    }
    
    return $result;
}
/*
function get_line_range(array $data, int $first = 0, int $last = 0): array
{

}

function merge_lines(array ...$datas): array
{

}

function merge_cols(array ...$datas): array
{

}

function del_lines(array $data, int ...$lines): array
{

}

function del_cols(array $data, string ...$colnames): array
{

}

function sort(array $data, array $order): array
{

}

function filter(array $data, callable $filter): array
{

}

function seek(array $data, array $regex): array
{

}

*/
