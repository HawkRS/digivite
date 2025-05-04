// Asumiendo que estás usando Vue 3 con Composition API y Axios
// Aquí tienes un ejemplo general para los componentes de Evento

// Componente: EventoForm.vue (para crear y editar)
<template>
  <div>
    <h2>{{ isEdit ? 'Editar Evento' : 'Nuevo Evento' }}</h2>
    <form @submit.prevent="handleSubmit">
      <label>Nombre:</label>
      <input v-model="form.nombre" required />

      <label>Fecha:</label>
      <input type="date" v-model="form.fecha" required />

      <label>Tipo:</label>
      <select v-model="form.tipo" required>
        <option>boda</option>
        <option>compromiso</option>
        <option>cumpleaños</option>
        <option>bautizo</option>
        <option>otro</option>
      </select>

      <label>Horario:</label>
      <input type="time" v-model="form.horario" required />

      <label>Ubicación:</label>
      <input v-model="form.ubicacion" required />

      <button type="submit">{{ isEdit ? 'Actualizar' : 'Crear' }}</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const isEdit = ref(false)

const form = ref({
  nombre: '',
  fecha: '',
  tipo: '',
  horario: '',
  ubicacion: '',
})

onMounted(async () => {
  if (route.params.id) {
    isEdit.value = true
    const res = await axios.get(`/api/eventos/${route.params.id}`)
    form.value = res.data
  }
})

const handleSubmit = async () => {
  if (isEdit.value) {
    await axios.put(`/api/eventos/${route.params.id}`, form.value)
  } else {
    await axios.post('/api/eventos', form.value)
  }
  router.push('/eventos')
}
</script>


// Componente: EventoList.vue (para mostrar y eliminar)
<template>
  <div>
    <h2>Eventos</h2>
    <router-link to="/eventos/nuevo">Nuevo Evento</router-link>
    <ul>
      <li v-for="evento in eventos" :key="evento.id">
        {{ evento.nombre }} - {{ evento.fecha }} - {{ evento.tipo }}
        <router-link :to="`/eventos/${evento.id}/editar`">✏️</router-link>
        <button @click="borrar(evento.id)">🗑️</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const eventos = ref([])

const cargarEventos = async () => {
  const res = await axios.get('/api/eventos')
  eventos.value = res.data
}

const borrar = async (id) => {
  if (confirm('¿Seguro que deseas eliminar este evento?')) {
    await axios.delete(`/api/eventos/${id}`)
    cargarEventos()
  }
}

onMounted(() => cargarEventos())
</script>
