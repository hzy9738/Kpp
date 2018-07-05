<style lang="less">

</style>

<template>
    <div>
        <Modal
                v-model="show"
                :title="title"
                width="400"
                :styles="{top: '20px'}"
        >
            <Form :model="formData" :label-width="100" ref="formData" style="padding-left: 10%">
                <Tree :data="permissions" show-checkbox ref="tree"></Tree>
            </Form>
            <div slot="footer">
            </div>
        </Modal>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData :{
                    route: [],
                    child_route: [],
                    use_route: [],
                },
                show : false,
                role: '',
                pages: [],
                childPages: [],
                uses: [],
                permissions:[],
                title:'查看权限'
            };
        },
        props: {
            permissionModel: false,
            role_id:0
        },
        created (){
        },
        methods: {
            // 获取树形权限
            getPermssions () {
                this.JAjax.postJson('role/permissions', {}, (res) => {
                    this.permissions = res.data;
                    this.permissions.forEach(page=>{
                        if(this.pages.indexOf(page.id) !== -1){
                            page.checked = true
                        }
                        page.children.forEach(childPage=>{
                            if(this.childPages.indexOf(childPage.id) !== -1){
                                childPage.checked = true
                            }
                            childPage.children.forEach(use=>{
                                if(this.uses.indexOf(use.id) !== -1) {
                                    use.checked = true
                                }
                            })
                        })
                    })
                });
            },
            // 获取当前角色的权限
            getTheRolePermission () {
                this.JAjax.postJson('role/permissions/'+this.role_id, {}, (res) => {
                    this.title = '查看权限'+ '（ '+res.data.role+' ）';
                    this.pages = res.data.pages.map(item=>item.id);
                    this.childPages = res.data.child_pages.map(item=>item.id);
                    this.uses = res.data.uses.map(item=>item.id);
                    this.getPermssions();
                });
            },

        },
        watch: {
            permissionModel () {
                this.show = true
                this.getTheRolePermission();
            },
        }
    };
</script>
