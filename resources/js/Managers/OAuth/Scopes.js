class ScopesManager {
  load() {
    return axios.get("/api/oauth/scopes").then((response) => response.data)
  }

  prepareDescription(description, { firm }) {
    return String(description).replaceAll("{firm}", firm)
  }
}

export const scopesManager = new ScopesManager()
