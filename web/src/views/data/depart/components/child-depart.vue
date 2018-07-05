<style lang="less">

</style>

<template>
    <div>
        <Modal
                v-model="show"
                title="新增子部门"
                @on-ok="ok"
                @on-cancel="cancel">
            <Form :model="formData" :label-width="100"  ref="formData">
                <FormItem label="子部门名称：" prop="depart">
                    <Input v-model="formData.depart" type="text" placeholder="请输入子部门名称" style="width: 80%"></Input>
                </FormItem>
            </Form>
        </Modal>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData :{
                    depart: '',
                },
                show : false,
            };
        },
        props: {
            childModel: false,
            depart_id: 0,
        },
        methods: {
            ok () {
                if( this.formData.depart !== '') {
                    this.JAjax.postJson('depart/add-child/'+this.depart_id, this.formData, res=>{
                        if ( res.code === 1){
                            this.$Message.success(res.message);
                            this.$emit('afresh_list', 'data')
                        }
                        setTimeout(()=>{
                            this.formData.depart = ''
                        },500)
                    })
                }
            },
            cancel () {
                // this.$Message.info('Clicked cancel');
            }
        },
        watch: {
            childModel () {
                this.show = true
            },
            depart_id () {
                this.depart_id = this.depart_id
            }
        }
    };
</script>
