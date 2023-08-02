// vite manifest
export default [
    {
        "file": "index.html",
        "src": "/index.html",
        "isAsset": true,
        "isEntry": true,
        "imports": [],
        "dynamicImports": [],
        "modules": {}
    },
    {
        "file": "src\\main.ts",
        "src": "/src/main.ts",
        "isAsset": false,
        "isEntry": true,
        "imports": [],
        "dynamicImports": [],
        "modules": {
            "./App.vue": [
                "src\\App.vue",
                "src\\components\\HelloWorld.vue"
            ],
            "vue": [
                "node_modules\\vue\\dist\\vue.runtime.esm-bundler.js"
            ]
        }
    }
]
