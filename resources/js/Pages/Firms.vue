<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Firms
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div v-for="firm in firms">
            Firm "{{ firm.title }}"
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
      firms: [],
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
      this.firms = [];
      this.loading = true
      // replace `getPost` with your data fetching util / API wrapper

      try {
        const response = await axios.get('/api/firms', {
          responseType: 'json',
        });
        this.firms = response.data.data;
      } catch (error) {
        this.error = error.toString();
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>
