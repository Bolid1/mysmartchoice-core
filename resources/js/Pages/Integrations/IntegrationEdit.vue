<template>
  <el-container>
    <el-header class="flex items-center">
      <card-header
        :exists="Boolean(integration.id)"
        :title="integration.title"
        :list-href="this.$route('integrations.index')"
        :delete-href="() => this.$route('integrations.destroy', integration)"
        :show-href="() => this.$route('integrations.show', integration)"
      />
    </el-header>

    <el-main>
      <el-card>
        <el-form label-position="left" label-width="100px" :model="form">
          <el-form-item label="Title" :error="form.errors.title">
            <el-input
              id="title"
              type="text"
              v-model="form.title"
              class="mt-1 block w-full"
              required
              autofocus
            />
          </el-form-item>

          <el-form-item label="Description" :error="form.errors.description">
            <el-input
              id="description"
              type="text"
              v-model="form.description"
              class="mt-1 block w-full"
              required
              autofocus
            />
          </el-form-item>

          <el-tabs>
            <el-tab-pane label="OAuth2">
              <el-form-item
                label="Client"
                :error="form.errors['settings.oauth2_client_id']"
              >
                <el-select
                  v-model="form.settings.oauth2_client_id"
                  placeholder="Please, select..."
                  class="mt-1 block w-full"
                  filterable
                >
                  <el-option
                    v-for="client in oauth_clients.data"
                    :key="client.id"
                    :label="`${client.name} [${client.redirect}]`"
                    :value="client.id"
                  >
                  </el-option>
                </el-select>
              </el-form-item>

              <el-form-item
                label="Scopes"
                :error="form.errors['settings.oauth2_scopes']"
              >
                <el-select
                  v-model="form.settings.oauth2_scopes"
                  placeholder="Please, select..."
                  class="mt-1 block w-full"
                  filterable
                  multiple
                >
                  <el-option
                    v-for="scope in oauth_scopes"
                    :key="scope.key"
                    :label="scope.description"
                    :value="scope.key"
                  >
                  </el-option>
                </el-select>
              </el-form-item>
            </el-tab-pane>
            <el-tab-pane disabled label="Key"></el-tab-pane>
            <el-tab-pane disabled label="No auth"></el-tab-pane>
          </el-tabs>

          <form-buttons-group
            :exists="Boolean(integration.id)"
            :form="form"
            :store-href="this.$route('integrations.store')"
            :update-href="
              () => this.$route('integrations.update', { integration })
            "
            :destroy-href="
              () => this.$route('integrations.destroy', { integration })
            "
          />

          <el-tabs v-if="integration.id">
            <el-tab-pane label="JavaScript">
              <el-form-item label="File with code">
                <el-upload
                  class="upload-demo"
                  drag
                  :action="`/api/integrations/${integration.id}/javascript`"
                  with-credentials
                  :file-list="javascript_files"
                  accept=".js"
                  :show-file-list="false"
                  :http-request="upload"
                >
                  <i class="el-icon-upload"></i>
                  <div class="el-upload__text">
                    Drop file here or <em>click to upload</em>
                  </div>
                </el-upload>
              </el-form-item>
            </el-tab-pane>
          </el-tabs>
        </el-form>
      </el-card>
    </el-main>
  </el-container>
</template>

<script>
  import { Link, useForm } from "@inertiajs/inertia-vue3"
  import { forEach, get, has, extend } from "lodash"
  import { scopesManager } from "@/Managers/OAuth/Scopes"
  import { defineComponent } from "vue"
  import DeleteButton from "@/Components/Buttons/DeleteButton"
  import ShowButton from "@/Components/Buttons/ShowButton"
  import FormButtonsGroup from "@/Components/Buttons/FormButtonsGroup"
  import CardHeader from "@/Components/CardHeader"

  export default defineComponent({
    props: ["integration"],
    components: {
      CardHeader,
      FormButtonsGroup,
      ShowButton,
      DeleteButton,
      Link,
    },
    data() {
      return {
        oauth_clients: {},
        oauth_scopes: [],
        javascript_files: [],
      }
    },
    setup(props) {
      const form = useForm({
        title: props.integration.title,
        description: props.integration.description,
        settings: extend(
          {
            auth: "oauth2",
            oauth2_client_id: "",
            oauth2_scopes: [],
          },
          props.integration.settings
        ),
      })

      return { form }
    },
    methods: {
      has,
      get,
      upload({
        action,
        data,
        file,
        filename,
        headers,
        onError,
        onProgress,
        onSuccess,
      }) {
        const formData = new FormData()

        formData.append(filename, file)

        forEach(data, (item, key) => {
          formData.append(key, item)
        })

        /*
         action: "/api/integrations/9/javascript"
         data: {}
         file: File {uid: 1629988444951, name: "scratch.js", lastModified: 1613861013187, lastModifiedDate: Sun Feb 21 2021 01:43:33 GMT+0300 (Москва, стандартное время), webkitRelativePath: "", …}
         filename: "file"
         headers: {}
         onError: (err) => {…}
         onProgress: (e) => { props.onProgress(e, rawFile); }
         onSuccess: (res) => {…}
         withCredentials: true
         */

        return axios
          .post(action, formData, {
            headers: Object.assign(
              { "Content-Type": "multipart/form-data" },
              headers
            ),
            onUploadProgress: onProgress,
          })
          .then(onSuccess, onError)
      },
    },
    created() {
      axios.get("/api/oauth/clients").then((response) => {
        this.oauth_clients = response.data
      })
      scopesManager.load().then((scopes) => {
        this.oauth_scopes = scopes
      })
    },
  })
</script>

<style scoped></style>
