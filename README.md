# Gerador de Códigos Únicos

Este projeto implementa a geração de códigos únicos com base em entropia e timestamp, com testes automatizados via PHPUnit.

## 📦 Instalação

Clone o repositório e execute:

```bash
composer install
````

Isso instalará todas as dependências necessárias.

## 🧪 Testes

Existem dois testes principais:

* **Entropia:** testa a parte de entropia do gerador.

  ```bash
  ./vendor/bin/phpunit binPartTest.php
  ```

* **Timestamp:** testa a parte de timestamp do gerador.

  ```bash
  ./vendor/bin/phpunit timestampPartTest.php
  ```

---

Sinta-se livre para mudar as variáveis de iterações para o valor que quiser. Mas lembre-se que você pode ter problemas de memória/CPU se extrapolar no valor.

OBS: Lembre-se de limpar o Redis ao fim de cada teste.
