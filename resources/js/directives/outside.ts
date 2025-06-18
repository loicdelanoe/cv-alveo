// const clickOutside = {
//   beforeMount(el, binding) {
//     // Check if binding.value is a function
//     if (typeof binding.value !== 'function') {
//       console.error('The value passed to v-click-outside must be a function.')
//       return
//     }

//     el.clickOutsideEvent = function (event: MouseEvent) {
//       // If the clicked target is not the element or its children, call the function
//       if (!(el === event.target || el.contains(event.target))) {
//         binding.value() // Call the function (which will update the ref)
//       }
//     }
//     document.addEventListener('click', el.clickOutsideEvent)
//   },
//   unmounted(el) {
//     document.removeEventListener('click', el.clickOutsideEvent)
//   },
// }

// export default clickOutside
