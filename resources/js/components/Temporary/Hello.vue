<template>
  How To Install Vue 3 in Laravel 10 : ZWebCourses
  <button id="jq-button">Click Me</button>
</template>
<script>
export default {
  mounted() {
    // Using jQuery
    $('#jq-button').on('click', function() {
      alert('Button clicked using jQuery!');
    });
  }
};
</script>
