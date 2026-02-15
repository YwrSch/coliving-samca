# Coliving SAMCA - Sistema para Apoio a Moradias Compartilhadas em Angicos.
- Este repositório contém os recursos e códigos desenvolvidos para o Trabalho de Conclusão de Curso (TCC) do Bacharelado em Sistemas de Informação: "Coliving SAMCA - Sistema para Apoio a Moradias Compartilhadas em Angicos".
- O objetivo central é mitigar as dificuldades enfrentadas pelos discentes da UFERSA (Campus Angicos) na busca por moradia adequada. O sistema digitaliza e centraliza as ofertas de aluguel e repúblicas, oferecendo não apenas um mural de anúncios, mas uma ferramenta de "Match de Convivência" que cruza o perfil do estudante com as regras dos imóveis.

# Status: Protótipo Funcional / Em Desenvolvimento
- Algoritmo de Compatibilidade (Match): Sistema de pontuação (Score 0-100%) que cruza os hábitos do estudante (pets, tabagismo, necessidade de silêncio, etc.) com as regras estabelecidas pelos proprietários dos imóveis.
- Painel do Estudante: Dashboard interativo com sugestões personalizadas ("Melhor Match"), ferramenta de busca com filtros e gestão de perfil de convivência.
- Painel do Proprietário: Ambiente de gestão de anúncios, controle de disponibilidade de vagas e visualização de alunos com perfil compatível com seus imóveis.
- Comunicação Direta (Chat): Sistema de mensagens assíncronas embutido na plataforma (via AJAX/JSON), permitindo o contato entre estudante e proprietário sem expor dados pessoais prematuramente.
Geolocalização: Visualização de imóveis em mapa dinâmico para facilitar a escolha baseada na localização.

# Atividades Propostas
## Reconhecimento e Pesquisa
-  [x] Realização de pesquisa de mercado sob sistemas com propostas semelhantes e análise de práticas informais já existentes na região.
-  [x] Estabelecimento da visão de alto nível do software e definição do foco temático.
## Planejamento e Modelagem
-  [x] Definição das tecnologias base.
-  [x] Estruturação do comportamento do sistema através da elaboração de Diagramas de Casos de Uso.
-  [x] Mapeamento detalhado das interações para três atores principais: Usuário geral, Estudante e Proprietário.
## Implementação (Desenvolvimento Iterativo)
-  [x] Implementação de autenticação e controle de níveis de acesso (Estudante vs. Proprietário).
-  [x] Criação das views customizadas e Dashboards.
-  [x] Implementação do sistema de mensagens na plataforma.
-  [x] Integração de mapas para visualização das ofertas.
-  [x] Sistema de recomendação básico (preferéncias do estudante vs. regras da propriedade).
-  [ ] Controle de ocupação das moradias.
-  [ ] Sistema de recomendação avançado (perfil dos estudantes que ocupam a propriedade).
## Avaliação e Monitoramento
-  [ ] Aplicação de testes para avaliar a funcionalidade e aceitação de cada novo incremento do sistema.
-  [ ] Interpretação dos problemas relatados, correlação com as premissas iniciais e planejamento de ciclos de melhorias.

# Tecnologias utilizadas
| Categoria | Tecnologia | Propósito / Aplicação |
| :--- | :--- | :--- |
| **Backend / Framework** | Laravel (PHP) | Base fundamental para o desenvolvimento da lógica de negócios e roteamento do sistema. |
| **Banco de Dados** | PostgreSQL | Gerenciamento e persistência de dados em um ambiente relacional seguro e robusto. |
| **Frontend** | HTML, CSS e JavaScript| Tecnologias essenciais utilizadas em conjunto para a estruturação, estilização e montagem das telas. |
| Estilização / UI | Materialize CSS | Componentes responsivos, modais e design material |
| **Geolocalização / Mapa** | Leaflet | Biblioteca implementada especificamente para a visualização de dados geográficos e criação de mapas interativos. |

# Equipe do Projeto
## Discente
- Ywry Scheller Medeiros Galvão (UFERSA)
## Docente Orientadora
- Prof. Dra. Samara Martins Nascimento Gonçalves (UFERSA)
## Banca Examinadora
- Prof. Dr. Reudismam Rolim de Sousa (UFERSA)
- Prof. Dr. Sairo Raoni dos Santos (UFERSA)

Trabalho apresentado ao Departamento de Ciências Exatas e Tecnologia da Informação - Bacharelado em Sistemas de Informação (UFERSA - Campus Angicos).
