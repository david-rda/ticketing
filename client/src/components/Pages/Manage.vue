<template>
    <div>
        <header-component></header-component>

        <div class="container mt-5 col-md-6 d-flex">
            <div class="row col-md-6 offset-3">
                <form method="POST" @submit.prevent="change_password()">
                    <div class="mb-4">
                        <label for="current_password">მიმდინარე პაროლი</label>
                        <input type="text" class="form-control" v-model="current_password" name="current_password" id="current_password">
                    </div>
                    <div class="mb-4">
                        <label for="new_password">ახალი პაროლი</label>
                        <input type="text" class="form-control" v-model="new_password" name="new_password" id="new_password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">პაროლის ცვლილება</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from "./Layouts/Header.vue";

    export default {
        name : "ManageProfile",

        components : {
            HeaderComponent
        },

        mounted() {
            document.title = "პროფილის მართვა";
        }
    }
</script>

<style scoped lang="scss">
    .container {
        background-color: #fff;
        border-radius: 6px;
        padding: 20px;
    }

    * {
        font-family: "neue_regular" !important;
    }

    label, button, input {
        font-size: 14px !important;
    }
</style>
