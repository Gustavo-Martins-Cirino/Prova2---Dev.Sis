# Prova 2 — Desenvolvimento de Sistemas

Projeto desenvolvido como avaliação da disciplina de Desenvolvimento de Sistemas.  
O objetivo é um **gerenciador de tarefas** com autenticação, CRUD completo e interface usando **Bootstrap 5**.

## Tecnologias
- **PHP**
- **MySQL**
- **Bootstrap 5** (via CDN)

## 🗃️ Banco de Dados

Crie o banco **tarefas** com as tabelas abaixo:

```sql
CREATE DATABASE tarefas;
USE tarefas;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(255) NOT NULL,
  senha VARCHAR(255) NOT NULL
);

CREATE TABLE tarefas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descricao TEXT,
  status ENUM('pendente','concluida') DEFAULT 'pendente',
  data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  usuario_id INT,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
```

**Usuário de teste**
- usuário: `admin`
- senha: `MD5("123456")`

## 📂 Estrutura do Projeto

- `conexao.php` — conexão PDO com o banco  
- `login.php` — autenticação com sessão  
- `logout.php` — encerra sessão  
- `index.php` — listagem de tarefas  
- `nova.php` — criação de tarefa  
- `editar.php` — edição de tarefa  
- `concluir.php` — altera status para concluída  
- `excluir.php` — remove tarefa  
- `layout.php` — cabeçalho e navbar reutilizáveis  

## 🔐 Funcionalidades

- Login com validação no banco e sessão
- CRUD completo de tarefas
- Status com badges coloridos
- Layout com Bootstrap 5 e componentes visuais

## ▶️ Como executar

1. Importe o banco com o script SQL (ou crie manualmente conforme acima).
2. Ajuste as credenciais em `conexao.php`.
3. Rode o projeto em um servidor local (XAMPP, WAMP, etc).
4. Acesse `login.php`.

---

Desafio proposto na prova de Desenvolvimento de Sistemas 
