<template>
    <div class="w100">
        <div class="new__email-bar">
            <div class="email__arrows">
                <i class="material-icons">arrow_back</i>
            </div>
            <div class="email__actions">
                <div class="action_group">
                    <i class="material-icons">attach_file</i>
                    <div class="action_text">Прикрепить</div>
                </div>
                <div class="action_group">
                    <i class="material-icons">archive</i>
                    <div class="action_text">Сохранить</div>
                </div>
                <div class="action_group">
                    <i class="material-icons">person_add</i>
                    <div class="action_text">Подпись</div>
                </div>
            </div>
            <div class="email__search-wrap">
                <div class="email__search">
                    <div class="input-field">
                        <input id="last_name" type="text" class="validate">
                        <label for="last_name">Поиск</label>
                        <i class="material-icons">search</i>
                    </div>
                </div>
            </div>
            <div class="email-dop">
                <div>
                    <i class="material-icons">local_printshop</i>
                </div>
                <div>
                    <i class="material-icons">settings</i>
                </div>
            </div>
        </div>
        <div id="editor">
            <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
        </div>
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';


    export default {
        name: 'app',
        data() {
            return {
                editor: ClassicEditor,
                editorData: '<p>Content of the editor.</p>',
                editorConfig: {
                    toolbar: [
                            'bold',
                            'italic',
                            'link',
                            'BulletedList',
                            'NumberedList',
                            'Blockquote',
                            'imageUpload',
                    ]
                }
            };
        },
    }
</script>

<style scoped>
    .new__email-bar {
        display: flex;
        align-items: center;
        background: #fff;
        border-bottom: 2px solid #F5F5F5;
        color: #D8D8D8;
        font-style: normal;
        font-weight: 500;
        font-size: 12px;
    }

    .new__email-bar i {
        width: 26px;
        height: 26px;
    }

    .email__actions {
        display: flex;
        border-right: 2px solid #F5F5F5;
    }

    .email__actions .action_group {
        padding: 20px 22px;
        text-align: center;
    }

    .email__search-wrap {
        padding: 6px 25px 6px 30px;
        border-right: 2px solid #F5F5F5;
    }

    .email__search div {
        display: flex;
        align-items: center;
    }

    .email__search i {
        position: relative;
        z-index: 222;
        cursor: pointer;
    }

    .email__arrows {
        padding: 32px 30px 30px 32px;
        display: flex;
        border-right: 2px solid #F5F5F5;
    }

    .email__actions .action_text {
        color: #CCCCCC;
    }

    .new__email-bar input {
        width: 240px !important;
        border-bottom: none !important;
        margin-bottom: 0 !important;
    }

    .new__email-bar label.active {
        color: #D8D8D8 !important;
    }

    .new__email-bar input:focus {
        box-shadow: none !important
    }

    .email-dop {
        display: flex
    }

    .email-dop div {
        padding: 29px 15px;
    }

    .email__arrows, .action_group, .email-dop div {
        cursor: pointer;
    }

    .email__arrows:hover, .action_group:hover, .email-dop div:hover {
        background: rgba(24, 117, 240, 0.16);
    }


</style>
