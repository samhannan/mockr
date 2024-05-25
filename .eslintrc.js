module.exports = {
    env: {
        node: true,
    },
    extends: ["eslint:recommended", "plugin:vue/vue3-recommended", "prettier"],
    rules: {
        "vue/html-closing-bracket-newline": [
            "error",
            {
                multiline: "always",
            },
        ],
    },
};
