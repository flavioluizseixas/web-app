<template>
  <div>
    <h1></h1>
    <ClienteForm />
    <ClienteList />
  </div>
</template>

<script>
import ClienteForm from './components/ClienteForm.vue';
import ClienteList from './components/ClienteList.vue';

export default {
  components: {
    ClienteForm,
    ClienteList
  }
};
</script>