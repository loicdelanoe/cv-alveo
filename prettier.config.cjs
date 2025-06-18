/* eslint-env node */

/** @type {import("@ianvs/prettier-plugin-sort-imports").PrettierConfig} */

module.exports = {
  printWidth: 100,
  tabWidth: 2,
  useTabs: false,
  semi: false,
  singleQuote: true,
  trailingComma: 'es5',
  bracketSpacing: true,
  arrowParens: 'avoid',
  overrides: [
    {
      files: '*.md',
      options: {
        parser: 'markdown',
      },
    },
  ],
  plugins: ['@ianvs/prettier-plugin-sort-imports'],
  importOrder: [
    '<BUILTIN_MODULES>',
    '',
    '<THIRD_PARTY_MODULES>',
    '',
    '^@/(.*)$',
    '^@lib/(.*)$',
    '^@sherlock/(.*)$',
    '',
    '^[./]',
    '',
    '<TYPES>',
    '<TYPES>^@/(.*)$',
    '<TYPES>^[./]',
  ],
}
