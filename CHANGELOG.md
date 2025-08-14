# Changelog

O formato segue o [Keep a Changelog](https://keepachangelog.com/), e este projeto adere ao [Versionamento Semântico](https://semver.org/lang/pt-BR/).

## [2.7.0] - 2025-08-14
### Adicionado
- **Cache de Token - API Itaú**:
  - Sistema de cache automático para tokens de autenticação, evitando autenticações desnecessárias e melhorando a performance.
  - Expiração inteligente com renovação automática após tempo configurável (padrão: 5 minutos).
  - Opções de cache:
    - Diretório padrão temporário
    - Diretório personalizado
    - Arquivo específico
    - Tempo de vida personalizado
  - Suporte a múltiplos clientes (`client_id`) com caches independentes.
  - Limpeza automática de tokens expirados.
  - Thread-safe.
  - Métodos utilitários para:
    - Verificar status do cache
    - Obter informações do cache
    - Limpar cache manualmente
    - Alterar tempo de vida em runtime
- Documentação completa de uso e exemplos em [CACHE_README.md](https://github.com/mastria/api-itau/blob/master/CACHE_README.md).

### Considerações de Segurança
- Arquivos criados com permissão `0644`.
- Diretórios de cache criados automaticamente com permissões adequadas.
- Tokens corrompidos ou inválidos são regenerados automaticamente.

---

## [2.1.19]
### Adicionado
- Classe de tratamento de string para remoção de acentos e caracteres especiais.
- Funcionalidade de alteração de valor de boleto.
- Melhorias no manual.

### Corrigido
- Textos de endereços.