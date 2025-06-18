export function dd(...args: unknown[]): never {
  console.log('')
  console.log('%c🧨 Debug Dump:', 'padding: 4px 8px; font-weight: bold; font-size: 16px;')

  args.forEach((arg, index) => {
    console.log(
      `%c→ Arg ${index + 1}:%c ${String(arg)}`,
      'padding: 4px 8px; font-weight: bold;',
      'padding: 4px 0;'
    )
  })

  console.log('')
  // Kill execution with a forced error
  throw new Error('💥 Execution stopped by dd()')
}
