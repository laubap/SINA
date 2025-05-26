function carregarConteudo(secao) {
    fetch(`conteudo/${secao}.php`)
      .then(response => {
        if (!response.ok) throw new Error("Erro ao carregar conteúdo");
        return response.text();
      })
      .then(html => {
        document.getElementById("conteudo").innerHTML = html;
      })
      .catch(error => {
        document.getElementById("conteudo").innerHTML = "Erro ao carregar a seção.";
      });
      
}
  