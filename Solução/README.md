# Passo-A-Passo usando LaravelAPI + Mysql + Vue.Js


## 1. Backend (Laravel)

Criação da API REST para cadastro de clientes.

Passo 1: Criar o projeto Laravel
```bash
composer create-project --prefer-dist laravel/laravel cliente-api
cd cliente-api
```

Passo 2: Configurar o banco de dados (MySQL)
No arquivo .env, configure as credenciais do banco:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cliente_db
DB_USERNAME=root
DB_PASSWORD=secret
```

Passo 3: Criar o modelo e a migração

```bash
php artisan make:model Cliente -m
```

No arquivo database/migrations/xxxx_xx_xx_xxxxxx_create_clientes_table.php, edite a estrutura da tabela:

```php
public function up()
{
    Schema::create('clientes', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->string('cpf')->unique();
        $table->string('cep');
        $table->string('endereco');
        $table->string('numero');
        $table->string('complemento')->nullable();
        $table->timestamps();
    });
}
```

Execute a migração:

```bash
php artisan migrate
```

Passo 4: Criar o Controller
```bash
php artisan make:controller ClienteController --resource
```

Edite app/Http/Controllers/ClienteController.php:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Http;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:clientes',
            'cep' => 'required|string|size:8',
            'numero' => 'required|string|max:10',
        ]);

        // Consultar endereço na API dos Correios (ViaCEP)
        $response = Http::get("https://viacep.com.br/ws/{$request->cep}/json/");
        if ($response->failed() || isset($response['erro'])) {
            return response()->json(['error' => 'CEP inválido'], 400);
        }

        $endereco = "{$response['logradouro']}, {$response['bairro']}, {$response['localidade']}-{$response['uf']}";

        $cliente = Cliente::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'cep' => $request->cep,
            'endereco' => $endereco,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
        ]);

        return response()->json($cliente, 201);
    }

    public function show($id)
    {
        return response()->json(Cliente::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());
        return response()->json($cliente);
    }

    public function destroy($id)
    {
        Cliente::destroy($id);
        return response()->json(['message' => 'Cliente removido']);
    }
}
```

Passo 5: Habilitar api

```bash
php artisan install:api
```

Passo 6: Configurar as Rotas
Em routes/api.php:

```php
use App\Http\Controllers\ClienteController;

Route::apiResource('clientes', ClienteController::class);
```
<!-- 
Passo 7: Configurar CORS
No arquivo app/Http/Middleware/VerifyCsrfToken.php, adicione a URL do frontend em cors.php:

php
Copiar
Editar
'allowed_origins' => ['http://localhost:5173']
-->

## 2. Frontend (Vue.js)

Criação da interface para interação com o backend.

Passo 1: Criar o projeto Vue.js

```bash
npm create vite@latest cliente-frontend --template vue
cd cliente-frontend
npm install axios
```

Passo 2: Criar o componente ClienteForm.vue
Crie src/components/ClienteForm.vue:

```vue
<template>
  <div>
    <h2>Cadastro de Cliente</h2>
    <form @submit.prevent="cadastrarCliente">
      <input v-model="cliente.nome" placeholder="Nome" required />
      <input v-model="cliente.cpf" placeholder="CPF" required />
      <input v-model="cliente.cep" placeholder="CEP" @blur="buscarEndereco" required />
      <input v-model="cliente.endereco" placeholder="Endereço" readonly />
      <input v-model="cliente.numero" placeholder="Número" required />
      <input v-model="cliente.complemento" placeholder="Complemento" />
      <button type="submit">Cadastrar</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      cliente: { nome: '', cpf: '', cep: '', endereco: '', numero: '', complemento: '' }
    };
  },
  methods: {
    async buscarEndereco() {
      if (this.cliente.cep.length === 8) {
        const response = await axios.get(`https://viacep.com.br/ws/${this.cliente.cep}/json/`);
        if (!response.data.erro) {
          this.cliente.endereco = `${response.data.logradouro}, ${response.data.bairro}, ${response.data.localidade} - ${response.data.uf}`;
        } else {
          alert('CEP inválido!');
        }
      }
    },
    async cadastrarCliente() {
      try {
        await axios.post('http://127.0.0.1:8000/api/clientes', this.cliente);
        alert('Cliente cadastrado com sucesso!');
      } catch (error) {
        alert('Erro ao cadastrar cliente.');
      }
    }
  }
};
</script>
```

Passo 3: Criar o componente ClienteList.vue
Crie src/components/ClienteList.vue:

```vue
<template>
  <div>
    <h2>Lista de Clientes</h2>
    <table>
      <tr>
        <th>Nome</th>
        <th>CPF</th>
        <th>Endereço</th>
        <th>Ações</th>
      </tr>
      <tr v-for="cliente in clientes" :key="cliente.id">
        <td>{{ cliente.nome }}</td>
        <td>{{ cliente.cpf }}</td>
        <td>{{ cliente.endereco }}</td>
        <td>
          <button @click="removerCliente(cliente.id)">Remover</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return { clientes: [] };
  },
  async mounted() {
    const response = await axios.get('http://127.0.0.1:8000/api/clientes');
    this.clientes = response.data;
  },
  methods: {
    async removerCliente(id) {
      await axios.delete(`http://127.0.0.1:8000/api/clientes/${id}`);
      this.clientes = this.clientes.filter(cliente => cliente.id !== id);
    }
  }
};
</script>
Passo 4: Configurar App.vue
No src/App.vue:

vue
Copiar
Editar
<template>
  <ClienteForm />
  <ClienteList />
</template>

<script>
import ClienteForm from './components/ClienteForm.vue';
import ClienteList from './components/ClienteList.vue';

export default { components: { ClienteForm, ClienteList } };
</script>
```

Passo 5: Executar o frontend

```bash
npm run dev
```
