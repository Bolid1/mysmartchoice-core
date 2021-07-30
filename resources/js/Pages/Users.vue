<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Users
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div v-for="user in users">
            User with name "{{ user.name }}" registered with email "{{ user.email }}"
          </div>
        </div>
      </div>
    </div>
  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
import axios from 'axios'

export default {
  components: {
    BreezeAuthenticatedLayout,
  },
  data () {
    return {
      loading: false,
      users: [],
      error: null,
    }
  },
  created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
  methods: {
    async fetchData () {
      this.error = null;
      this.users = [];
      this.loading = true
      // replace `getPost` with your data fetching util / API wrapper

      try {
        const response = await axios.get('/api/users', {
          responseType: 'json',
        });
        this.users = response.data.data;
      } catch (error) {
        this.error = error.toString();
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>
