# vue_2

## Project Structure
```
.
└── Vue
    ├── apiConfig -- Configuration files for development/production environment 
    │   ├── apiConfigDev.json
    │   └── apiConfigProd.json
    ├── package.json -- Package dependencies
    ├── src
    │   ├── App.vue -- The base for SPA
    │   ├── assets -- Static resource like images/logos
    │   ├── components -- Components for reuse
    │   ├── main.js -- Vue app initialization
    │   ├── page -- Pages for vue-router
    │   ├── php -- Backend php code
    │   ├── router -- Configuration for vue-router
    │   └── store -- Configuration for vuex
```

## Project setup
```
git clone https://github.com/xlab-classes/cse442-spring2022-team-nohtyp.git
cd Vue
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).
