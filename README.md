# Projeto Backend - Questão 10 do Teste Técnico (Laravel + Vue)

Este repositório contém a implementação do backend desenvolvida para a **Questão 10** do teste técnico. O projeto utiliza as ferramentas e tecnologias mais recentes para atender aos requisitos propostos.

---

## Ferramentas Utilizadas

-   **PHP 8+**
-   **Laravel 10 (LTS)**
-   **Laravel Sanctum**
-   **SQLite**  
    _Optei pelo SQLite por não requerer a instalação de um servidor de banco de dados separado._

---

## Pré-Requisitos

-   **PHP 8+**
-   **Composer**
-   **Git**

---

## Instalação e Configuração

Após clonar o repositório, siga os passos abaixo na pasta raiz do projeto:

1.  **Instalar as dependências do Composer:**

    ```bash
    composer install
    ```

2.  **Copiar o arquivo .env.example que já está configurado com variveis para utilizar com o vue:**

    Linux

    ```bash
        cp .env.example .env
    ```

    Windows

    ```bash
        copy .env.example .env
    ```

3.  **Executar os comandos do Laravel**

    ```bash
        php artisan migrate
     
        php artisan key:generate

        php artisan storage:link
    
        php artisan serve
    ```
---

## Considerações

Necessário realizar o download e a instalação do frontend do projeto em https://github.com/th08/avaliacao-chico-rei-frontend
