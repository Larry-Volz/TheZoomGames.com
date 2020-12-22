# Zoom

## Zoom account settings

### `Zoom Marketplace` > `Oauth app` > `App Credentials`

#### App Credentials

* Redirect URL for OAuth

```
http(s)://your.domain.name/requestToken
```

#### Whitelist URL

* List

```
http(s)://your.domain.name/requestToken
```

---

### `Zoom Marketplace` > `Oauth app` > `Scopes`

#### Add Scopes

* **Meeting >** ***View your meetings*** `/meeting:read`

* **Meeting >** ***View and manage yourmeetings*** `/meeting:write`
