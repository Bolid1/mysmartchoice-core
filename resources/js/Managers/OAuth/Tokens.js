class TokensManager {
  load() {
    return axios.get("/api/oauth/tokens/").then((response) => response.data)
  }

  revoke(token) {
    return axios.delete(`/api/oauth/tokens/${token.id}`)
  }
}

export const tokensManager = new TokensManager()
