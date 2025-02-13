<template>
  <div class="form-container">
    <h2>Lista de Clientes</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Nome</th>
          <th>CPF</th>
          <th>Endereço</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cliente in clientes" :key="cliente.id">
          <td>{{ cliente.nome }}</td>
          <td>{{ cliente.cpf }}</td>
          <td>{{ cliente.endereco }}</td>
          <td>
            <button @click="removerCliente(cliente.id)" class="button delete">Remover</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      cliente: { nome: '', cpf: '', cep: '', endereco: '', numero: '', complemento: '' },
      clientes: []
    };
  },
  async mounted() {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/clientes');
      this.clientes = response.data;
    } catch (error) {
      console.error("Erro ao buscar clientes:", error);
    }
  },
  methods: {
    async removerCliente(id) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/clientes/${id}`);
        this.clientes = this.clientes.filter(cliente => cliente.id !== id);
      } catch (error) {
        console.error("Erro ao remover cliente:", error);
      }
    }
  }
};
</script>

<style>
.form-container {
  max-width: 600px;
  margin: 10px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.form {
  display: flex;
  flex-direction: column;
}

.input {
  margin-bottom: 10px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.button {
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.button.delete {
  background-color: #dc3545;
}

.button:hover {
  background-color: #0056b3;
}

.table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.table th, .table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.table th {
  background-color: #f2f2f2;
}
</style>
