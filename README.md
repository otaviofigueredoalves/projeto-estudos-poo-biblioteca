<div align="center">
<h1>📚 Sistema de Biblioteca POO</h1>

<p>
Um laboratório prático de <strong>Arquitetura de Software</strong> e <strong>PHP Moderno</strong>.
</p>

</div>

## <h2> 🎯 Sobre o Projeto </h2>

Este projeto não é apenas um sistema de biblioteca; é um estudo aprofundado sobre como escrever código limpo, desacoplado e orientado a objetos de verdade. O foco não está na interface gráfica, mas na Engenharia de Software por trás das regras de negócio. O sistema simula o fluxo de uma biblioteca (catalogação, empréstimo, devolução) aplicando rigorosamente os pilares da POO e padrões de projeto.

## <h2>✨ Principais Funcionalidades </h2>

- Gestão de Acervo: Adicionar e remover livros.

- Fluxo de Empréstimo: Validação de regras de negócio (limite por usuário, disponibilidade).

- Sistema de Logs: Rastreamento de ações via Traits.

## <h2>🧠 Princípios, Arquitetura e Boas Práticas </h2>

Abaixo, detalho como transformei teoria em prática neste código, mapeando cada implementação ao seu princípio correspondente:

<table>
<thead>
<tr>
<th>Princípio / Prática</th>
<th>Aplicação no Projeto</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>S.O.L.I.D. (DIP)</strong>



<em>Inversão de Dependência</em></td>
<td>Classes como <code>Bibliotecario</code> e <code>Estante</code> não criam suas dependências internamente (com <code>new</code>). Elas as recebem prontas via construtor, garantindo desacoplamento.</td>
</tr>
<tr>
<td><strong>Tell, Don't Ask</strong>



<em>Encapsulamento</em></td>
<td>O <code>Bibliotecario</code> não pergunta <em>"posso emprestar?"</em> para tomar decisão. Ele manda o livro se emprestar. Se não for possível, o próprio objeto <code>Livro</code> lança uma exceção, protegendo seu estado interno.</td>
</tr>
<tr>
<td><strong>D.R.Y. (Don't Repeat Yourself)</strong>



<em>Reutilização Horizontal</em></td>
<td>Utilização da Trait <code>Logger</code> para centralizar a lógica de logs e compartilhá-la entre classes de famílias diferentes (Estante e Usuário) sem forçar herança.</td>
</tr>
<tr>
<td><strong>S.O.L.I.D. (OCP)</strong>



<em>Open/Closed Principle</em></td>
<td>Uso de Classes Abstratas e Polimorfismo permite que o sistema seja estendido com novos formatos ou comportamentos sem modificar o código que consome essas classes.</td>
</tr>
<tr>
<td><strong>Fail Fast & Early Return</strong>



<em>Programação Defensiva</em></td>
<td>Validações ocorrem no início dos métodos (Guard Clauses). Se algo estiver errado, o código para imediatamente, evitando aninhamento de <code>if/else</code> e estados inconsistentes.</td>
</tr>
</tbody>
</table>

## <h2>🛠️ Como Rodar Localmente </h2>

1. Certifique-se de ter o PHP 8.0+ e o Composer instalados.

2. Clone o repositório:

- git clone https://github.com/otaviofigueredoalves/projetos-estudos-poo-biblioteca


3. Instale as dependências e gere o autoloader:

- composer dump-autoload

4. Rode o servidor
- php -S localhost:8000

5. Abra o link e seja feliz

<div align="center">
<small>Desenvolvido para fins de estudo por <strong>[Otavio Figueredo]</strong>.</small>
</div>
