Especificação da Linguagem [nome?] (Versão 0.1)
=============================

Características da linguagem
=============================

• Imperativa;• Fortemente tipada;• Declaração explícita de variáveis;• Vinculação estática de tipos;• Sistema de escopo estático (léxico);• Sensível à caixa (case-sensitive);


Sistema de Tipos
=============================

A linguagem possui um sistema de tipo com duas classes: tipos primitivos e tiposagregados.


Tipos primitivos
=============================

Os tipos primitivos são números inteiros, valores lógicos e strings, representadosrespectivamente pelos tipos int, bool e string.


Tipos Compostos (arranjo)
=============================

O tipo agregado é um arranjo de algum tipo primitivo. Dessa forma, podemos ter asvariantes: arranjo de inteiros, arranjo de lógicos e arranjo de strings.


O tipo string
=============================

Dados do tipo string são constantes e não são indexados como na maioria das linguagens.O objetivo da existência do tipo string na linguagem é apenas fornecer uma maneira deapresentar (escrever) mensagens na tela.


Especificação Léxica
=============================

Identificadores
########################

Chamamos de identificador qualquer nome criado pelo usuário da linguagem. Osidentificadores seguem a mesma regra de formação da linguagem C:• Devem iniciar com uma letra (minúscula ou maiúscula) ou um subtraço seguido deletras, subtraços ou dígitos entre 0 e 9.Um identificador será expresso pelo símbolo id nas especificações sintáticas.


Números
########################

Os números devem ser representados na base decimal e podem conter qualquercombinação de dígitos entre 0 e 9. Os números negativos não serão processados na faseléxica, mas sim na sintática e semântica. Dessa forma, o número -42, por exemplo,consiste de dois lexemas: '-' e '42', e serão tratados como uma operação aritmética nasanálises sintática e semântica.


Strings
########################

As strings possuem a mesma regra de formação definida pela linguagem C.


Comentários
########################

A linguagem possui apenas comentários de linha:• Começam com // e seguem até o final da linha.De forma geral, os comentários podem conter qualquer tipo de símbolo, inclusive os nãopermitidos pela linguagem. Os comentários devem ser processados corretamente peloanalisador léxico e em seguida descartados.


Palavras reservadas e símbolos
########################

As palavras reservadas e símbolos da linguagem são:bool false for if int read return skip stop string true while write( ) [ ] { } , ; + - * / == != > >= < 


Especificação Sintática
=============================

Programa
########################

Um programa consiste de uma sequência não vazia de declarações de variáveis esubprogramas.programa ::= dec {dec}


Variáveis
########################

Existem dois tipos de variáveis: as simples e as agregadas. Variáveis simples suportamapenas um único valor de um determinado tipo primitivo em um determinado momento.Variáveis agregadas são de tipos compostos (arranjos), suportando mais de um valor deum mesmo tipo em um determinado momento.


Declaração de Variáveis
########################

decVar ::= 'var' listaSpecVars ':' tipo ';'listaSpecVars ::= specVar {',' specVar}specVar ::= specVarSimples | specVarSimplesIni |specVarArranjo | specVarArranjoIniObserve que a declaração de variáveis é indicada pela palavra reservada var. Observetambém que múltiplas variáveis podem ser declaradas de uma vez e que elas podem serinicializadas durante a declaração. Veja que, para os arranjos, o tamanho do mesmotambém deve ser especificado na declaração


Subprogramas (procedimentos e funções)
########################

A definição de procedimentos e funções possui uma sintaxe comum, exceto pela ausênciado tipo de retorno para procedimentos. Diferentemente da linguagem C, por exemplo,não há separação entre declaração e definição de subprogramas, isto é, o subprograma édeclarado durante sua própria definição.Exemplo:Declaração de Procedimento Declração de Funçãodef proc(y: int) {if (y < 0) {return;}x = 2 * y;}def func(x, y: int): int {z = x * y: int;return z + 1;}


Declaração de Subprogramas
########################

decSub ::= decProc | decFunc


Declaração de procedimento
########################

decProc ::= 'def' id '(' [listaParâmetros] ')' bloco


Declaração de função
########################

decFunc ::= 'def' id '(' [listaParâmetros] ')' ':' tipo bloco


Lista de Parâmetros
########################

listaParâmetros ::= paramsSpec {';' paramsSpec}paramsSpec ::= param {, param} : tipoparam ::= id | id '[]Parâmetros de tipo primitivo são passados naturalmente por cópia e parâmetros de tipoarranjo são passados naturalmente por referência.


Comandos
=============================

Um comando pode ser um comando simples ou bloco de comandos.cmd ::= cmdSimples | blocoA seguir são relacionados os comandos simples da linguagem:


Atribuição
########################

cmdAtrib ::= atrib ';'atrib ::= variável ('='|'+='|'-='|'*='|'/='|'%=') expressãoO comando de atribuição avalia o valor da expressão e o armazena na variável.Uma atribuição somente pode ocorrer se a variável foi previamente declarada e se otipo do resultado da expressão é o mesmo indicado na declaração da variável.As atribuições compostas devem ser traduzidas da seguinte maneira:var X= expressão -> var = var X expressão


Condicional If:
########################

cmdIf ::= 'if' '(' expressão ')' comando ['else' comando]A estrutura condicional if é executada verificando o resultado da expressão de teste.Se ela resultar no valor true, apenas o primeiro comando será executado. Se aexpressão resultar no valor false, caso a estrutura else esteja presente, apenas osegundo comando será executado.


Laço While:
########################

cmdWhile ::= 'while' '(' expressão ')' comandoO laço while inicia verificando o resultado da expressão de teste. Caso o valor sejatrue, o comando do seu corpo é executado e o laço volta a testar o valor da expressãode teste para a próxima iteração. Caso o valor seja false, a execução do laço éinterrompida.


Laço For:
########################

cmdFor ::= 'for' '(' atrib-ini ';' expressão ';' atrib-passo ')' comandoO laço for inicia executando a atribuição de inicialização. A partir daí, antes de cadaiteração, o resultado da expressão de teste é verificado. Se ele for true, o comandocorpo é executado e o a atribuição de passo é executada em seguida, reiniciando oprocesso. Se antes de qualquer iteração o valor resultado pela expressão de teste forfalse, a execução do laço é interrompida.


Interrupção do laço:
########################

cmdStop ::= 'stop' ';'O comando stop interrompe o laço mais próximo que o cerca. Ele só pode aparecerdentro do corpo de comandos de repetição while e for.


Salto de iteração do laço:
########################

cmdSkip ::= 'skip' ';'O comando skip salta para a próxima iteração do laço mais próximo que o cerca,ignorando a execução dos comandos que o seguem dentro deste laço. Ele só podeaparecer dentro do corpo de comandos de repetição while e for.


Retorno de subprograma:
########################

cmdReturn ::= 'return' [expressão] ';'O comando return encerra a execução do subprograma que o cerca retornando ovalor resultado pela expressão. A expressão de retorno de uma função deve resultarem um valor do mesmo tipo para o qual a função foi definida. Funções devemobrigatoriamente conter pelo menos um comando return. Já procedimentos podemou não conter comandos return. Caso o tenham, eles devem retornar nada: return;Como o programa principal é definido por meio de uma função, ele deve conter pelomenos um comando return e o valor retornado deve ser um número inteiro.


Chamada de procedimento:
########################

cmdChamadaProc ::= id '(' expressão [, expressão] ')' ';'Como a chamada de procedimentos não resulta em um valor, é necessário umcomando para sua execução. A chamada de funções possui sintaxe semelhante,exceto por não ser um comando, e sim uma expressão.


Entrada Read:
########################

cmdRead ::= 'read' variável ';'


Saída Write:
########################

cmdWite ::= 'write' expressão [, expressão] ';'


Bloco
########################

Um bloco é uma sequência de (nenhuma ou várias) declarações de subprogramas evariáveis seguida de uma sequência de (nenhum ou vários) comandos. Um bloco écircundado por chaves { }.bloco ::= '{' {decVar} {comando} '}'


Expressão
=============================

Uma expressão pode conter valores dos três tipos definidos (inteiros, lógicos e strings),uso de variáveis, chamadas de função e outras expressões. Uma expressão pode estarcercada por parênteses e se relacionar a outras expressões por meio dos seguintesoperadores:--- TABELA ---


O operador condicional ternário é formado da seguinte maneira:opTern ::= expressão-teste '?' expressão-então ':' expressão-senãoA expressão teste é avaliada. Se o resultado for true a expressão então é resultada,caso contrário, a expressão senão é resultada. Dessa forma, o resultado desseoperador é sempre uma expressão. O operador pode ser utilizado assim: x = a > 0 ?a * 2 : a + 1;


Uso de variável
########################

Como o uso de uma variável resulta no valor armazenado pela variável, todo uso devariável é uma expressão. Variáveis simples são usadas por meio do identificador (nome)associado a ela e variáveis compostas (arranjo) são usadas por meio do identificador e aposição numérica do elemento acessado.variável ::= id | id '[' expressão ']'Observe que a sintaxe do uso de variável não impede que uma variável declarada comosimples seja utilizada como arranjo. Essa associação deve ser verificada na etapa deanálise semântica.


Especificação Semântica
=============================

Programa
########################

A última declaração deve ser obrigatoriamente a da rotina principal, pela qual se dará oinício da execução do programa. Todas as declarações realizadas no programa (fora dequalquer subprograma) estão dentro do escopo global.


Declaração
########################

• Declaração de variáveis, funções e procedimentos são responsáveis por adicionaros símbolos envolvidos e suas vinculações na tabela de símbolos.• Caso a declaração de uma variável contenha a inicialização da mesma, o tipo daexpressão de inicialização deve ser o mesmo da variável.• A última declaração global deve ser de uma função chamada "main" do tip


Comandos:
=============================

If
########################

• A expressão condicional do comando if deve resultar em um valor do tipo lógico.


While
########################

• A expressão condicional do comando while deve resultar em um valor do tipológico.


For
########################

• As atribuições da inicialização e do passo devem ser analisadas como um comandode atribuição normal• A expressão condicional deve resultar em um valor do tipo lógico.


Stop
########################

• O comando stop só pode aparecer dentro de um comando de repetição (while oufor).


Skip
########################

• O comando skip só pode aparecer dentro de um comando de repetição (while oufor).


Return
########################

• Caso apareça dentro de uma função, o tipo da expressão de retorno deve ser omesmo do retorno declarado da função. Caso apareça dentro de um procedimento,o comando return não pode ter expressão.


Read
########################

• A variável utilizada no comando read deve estar declarada e visível no escopoatual.


Write
########################

• Não há análise especial para o comando write.Chamada de procedimento• O procedimento chamado deve estar declarado e visível no escopo atual.• O número de argumentos fornecidos deve ser o mesmo da declaração doprocedimento.• Os argumentos fornecidos devem ter a mesma ordem de tipo utilizada nadeclaração do procedimento.


Atribuição
########################

• O lado esquerdo da atribuição deve ser uma variável declarada e visível no escopoatual (simples ou acesso de array)• O lado direito deve ser uma expressão com tipo igual ao da variável do ladoesquerdo da atribuição.


Bloco
########################

• Define um novo escopo estático. O escopo é criado no início do bloco e finalizadono término do bloco.


Expressões
=============================

Aritmética (+ - * / % neg)
########################

• O(s) operando(s) devem ser do tipo inteiro. O tipo resultante é inteiro.


Relacional (> >= < 
########################

• Os operandos devem ser do tipo inteiro. O tipo resultante é lógico.


Igualdade (== !=)
########################

• Os operandos devem ser do mesmo tipo. O tipo resultante é lógico.


Lógica (&& || !)
########################

• O(s) operando(s) devem ser do tipo lógico. O tipo resultante é lógico.


Ternária
########################

• A expressão condicional deve resultar um valor do tipo lógico.• As expressões consequente e alternativa devem possuir o mesmo tipo.• O tipo resultante é o mesmo tipo da expressão consequente.


Uso de variável
########################

• A variável deve estar declarada e visível no escopo atual. O tipo resultante é o tipodeclarado da variável.


Chamada de função:
########################

• Análise análoga à chamada de procedimento.• O tipo resultante é igual ao tipo declarado da funçã


