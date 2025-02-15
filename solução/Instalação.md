## 1. Pré-requisitos
Antes de começar, certifique-se de ter os seguintes itens instalados:

- PHP 8+ ([Download](https://www.php.net/downloads))
- Composer ([Download](https://getcomposer.org/))
- Node.js e npm ([Download](https://nodejs.org/))
- Laravel Installer (Pode usar Composer)
- MySQL ([Download](https://dev.mysql.com/downloads/))
- Git ([Download](https://git-scm.com/))

# Parte 1: Configuração do Backend com Laravel

## 2. Criando um novo projeto Laravel

Execute no terminal:

```bash
composer create-project --prefer-dist laravel/laravel backend
cd backend
```

Ou, se tiver o Laravel Installer instalado:

```bash
laravel new backend
cd backend
```

## 3. Configurando o Banco de Dados

Copie o arquivo .env.example e renomeie para .env:

```bash
cp .env.example .env
```

Abra o arquivo .env e edite as configurações do banco de dados:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=backend_db
DB_USERNAME=root
DB_PASSWORD=suasenha
```

Crie o banco de dados no MySQL:

```sql
CREATE DATABASE backend_db;
```

Execute a migração para criar as tabelas:

```bash
php artisan migrate
```

## 4. Configurando o Servidor

Inicie o servidor Laravel:

```bash
php artisan serve
```

O backend estará rodando em http://127.0.0.1:8000.

# Parte 2: Criando a API no Laravel

## 5. Criando um Controller e Model

Vamos criar um recurso chamado "Post":

```bash
php artisan make:model Post -mcr
```

Isso cria:

- O modelo Post.php
- O controlador PostController.php
- A migration xxxx_xx_xx_xxxxxx_create_posts_table.php

## 6. Definindo a Migration

Edite database/migrations/xxxx_xx_xx_xxxxxx_create_posts_table.php:

```php
public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('content');
        $table->timestamps();
    });
}
```

Execute a migração:

```bash
php artisan migrate
```

## 7. Configurando o Model

Edite app/Models/Post.php:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content'];
}
```

## 8. Criando as Rotas da API

Edite routes/api.php:

```php
use App\Http\Controllers\PostController;

Route::apiResource('posts', PostController::class);
```

## 9. Configurando o Controller

Edite app/Http/Controllers/PostController.php:

```php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::all());
    }

    public function store(Request $request)
    {
        $post = Post::create($request->all());
        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(null, 204);
    }
}
```

Agora, sua API está funcional e pode ser testada via Postman ou cURL.

# Parte 3: Configuração do Frontend com Vue.js

## 10. Criando o Projeto Vue

No diretório raiz do projeto:

```bash
npx create-vue frontend
cd frontend
npm install
```

## 11. Instalando Axios para Consumo da API

```bash
npm install axios
```

## 12. Criando um Serviço para a API

Crie src/services/api.js:

```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api'
});

export default api;
```

## 13. Criando um Componente para Listar Posts

Crie src/components/PostList.vue:

```vue
<script setup>
import { ref, onMounted } from 'vue';
import api from '../services/api';

const posts = ref([]);

const fetchPosts = async () => {
  const response = await api.get('/posts');
  posts.value = response.data;
};

onMounted(fetchPosts);
</script>

<template>
  <div>
    <h1>Lista de Posts</h1>
    <ul>
      <li v-for="post in posts" :key="post.id">
        <h3>{{ post.title }}</h3>
        <p>{{ post.content }}</p>
      </li>
    </ul>
  </div>
</template>
```

## 14. Configurando a Rota no Vue

Edite src/App.vue:

```vue
<script setup>
import PostList from './components/PostList.vue';
</script>

<template>
  <div id="app">
    <PostList />
  </div>
</template>
```

## 15. Iniciando o Servidor Vue

```bash
npm run dev
```

Acesse http://localhost:5173 para visualizar a aplicação.