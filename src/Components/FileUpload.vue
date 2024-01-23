<script setup>
import { ref } from "vue";

const emit = defineEmits(["update:modelValue"]);

const file = ref(null);
const file_name = ref(null);
const uploaded_file_name = ref(null);
const isSending = ref(false);
const chunks = ref([]);
const uploaded = ref(0);

const upload = (event) => {
    var file_data = event.target.files[0];
    file.value = file_data;
    file_name.value = file_data.name;
    createChunks();
};

const uploadFile = () => {
    isSending.value = true;
    axios(config())
        .then((response) => {
            chunks.value.shift();
            if (response.data.uploaded) {
                uploadFile();
            } else {
                uploaded_file_name.value = response.data.name;
                emit("update:modelValue", response.data.name);
                isSending.value = false;
            }
        })
        .catch((error) => {
            console.log(error);
        });
}

const progress = () => {
    if (file.value) {
        return Math.floor((uploaded.value * 100) / file.value.size);
    }
    return 0;
}

const formData = () => {
    let formData = new FormData();
    formData.set("is_last", chunks.value.length === 1);
    formData.set("file", chunks.value[0], `${file.value.name}.part`);
    formData.set("name", file_name.value);
    return formData;
}

const createChunks = () => {
    console.log(file.value);
    let size = 2048 * 1000,
        chunks_data = Math.ceil(file.value.size / size);
    for (let i = 0; i < chunks_data; i++) {
        chunks.value.push(
            file.value.slice(
                i * size,
                Math.min(i * size + size, file.value.size),
                file.value.type
            )
        );
    }
}

const deleteFile = () => {
    if (uploaded_file_name.value) {
        axios.post(route('chunk-upload.delete_file', uploaded_file_name.value)).then(response => {
            uploaded_file_name.value = null;
            emit("update:modelValue", null);
        });
    }

    file.value = null;
    file_name.value = null;
    uploaded_file_name.value = null;
    isSending.value = false;
    chunks.value = [];
    uploaded.value = 0;
};

const config = () => {
    return {
        method: "POST",
        data: formData(),
        url: route("chunk-upload.upload"),
        headers: {
            "Content-Type": "application/octet-stream",
        },
        onUploadProgress: (event) => {
            uploaded.value += event.loaded;
        }
    };
}

</script>

<template>
    <div>
        <input type="file" @change="upload" />
        <button v-if="file" :disabled="isSending" @click="uploadFile()">Upload</button>
        <button v-if="uploaded_file_name" :disabled="isSending" @click="deleteFile()">Delete File</button>
        <h2>Progress: {{ progress() }} %</h2>
        {{ file_name }}
    </div>
</template>
