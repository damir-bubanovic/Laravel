<?php 
/*

!! ULTRA - UPLOAD - FILES - FULL PROCESS WITH VUE.JS & AXIOS!!

> Main.vue > 

*/
?>

<template>
	<form role="form" class="form" v-on:submit.prevent="onSubmit">
		<div class="form-group">
			<label for="file">File</label>
			<input id="file" type="file" class="form-control"/>
		</div>
		<button type="submit" class="btn btn-primary">Upload</button>
	</form>
</template>

<script>
    export default {
        methods: {
            onSubmit(file) {
                let data = new FormData();
                data.append('file', document.getElementById('file').files[0]);

                axios.post('api/route-post', data);
            }
        }
    }
</script>

<?php 
/**
 * Post Routes & Post Mountains
 */
public function postRoute(Request $request) {

	if($request->hasFile('file')) {
		Storage::putFile('public', $request->file('file'));
		return 'It is a file';
	} else {
		return 'No file uploaded';
	}

}
?>