<template>
  <div class="form-container">
    <h2>Cadastro de Cliente</h2>
    <form @submit.prevent="cadastrarCliente" class="form">
      <input v-model="cliente.nome" placeholder="Nome" class="input" required />
      <input v-model="cliente.cpf" placeholder="CPF" class="input" required />
      <input v-model="cliente.cep" placeholder="CEP" @blur="buscarEndereco" class="input" required />
      <input v-model="cliente.endereco" placeholder="Endereço" class="input" readonly />
      <input v-model="cliente.numero" placeholder="Número" class="input" required />
      <input v-model="cliente.complemento" placeholder="Complemento" class="input" />
      
      <button type="submit" class="button">Cadastrar</button>
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
        try {
          const response = await axios.get(`https://viacep.com.br/ws/${this.cliente.cep}/json/`);
          if (!response.data.erro) {
            this.cliente.endereco = `${response.data.logradouro}, ${response.data.bairro}, ${response.data.localidade} - ${response.data.uf}`;
          } else {
            alert('CEP inválido!');
          }
        } catch (error) {
          alert('Erro ao buscar o endereço.');
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

<style>
.form-container {
  max-width: 500px;
  margin: 0 auto;
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

.button:hover {
  background-color: #0056b3;
}
</style>