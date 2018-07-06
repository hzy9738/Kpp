<style lang="less">
    @import '../../../styles/common.less';
    @import './components/table.less';

</style>

<template>
    <div>
        <Row :gutter="10">
            <Col span="8">
                <Card>
                    <p slot="title">
                        <Icon type="cube"></Icon>
                        <span>章节目录</span>
                    </p>
                    <Row class="margin-top-8">
                        <can-edit-table
                                refs="table1"
                                :dataList="dataList"
                                @detail="detail"
                                class="margin-bottom-10">
                        </can-edit-table>
                    </Row>
                </Card>
            </Col>

            <Col span="16">
                <Card>
                    <p slot="title">
                        <Icon type="cube"></Icon>
                        <span>内容详情</span>
                    </p>
                    <Row class="margin-top-8">
                        <Col span="18">
                            <Input v-model="content" type="textarea" :autosize="{minRows: 20,maxRows: 5}"
                                   placeholder="Enter something..."></Input>
                        </Col>
                        <Col span="6">
                            <Tag v-for="item in tags" :key="item" :name="item" closable @on-close="handleClose2"
                                 style="margin:5px 20px">{{ item }}
                            </Tag>

                        </Col>

                    </Row>

                    <Row class="margin-top-8">
                        <Col span="18">
                            <Button type="info" style="margin-left: 10px" @click="saveContent">保存</Button>
                            <Button type="info" style="margin-left: 20px" @click="getTag">分词</Button>
                        </Col>
                    </Row>
                </Card>
            </Col>

        </Row>
    </div>
</template>

<script>
    import canEditTable from './components/canEditTable.vue';


    export default {
        name: 'searchable-table',
        components: {
            canEditTable,
        },
        data() {
            return {
                dataList: [],
                content: '',
                tags: [],
                title_id:'',
                category_id:'',
            };
        },
        methods: {
            saveContent() {
                let formData = {
                    content: this.content,
                    title: this.title_id,

                }
                this.JAjax.postJson('content/save', formData, (res) => {
                    this.tags = res.data
                });
            },
            handleClose2(event, name) {
                const index = this.tags.indexOf(name);
                this.tags.splice(index, 1);
            },
            getTag() {
                this.JAjax.postJson('word/tags', {content: this.content}, (res) => {
                    this.tags = res.data
                });
            },
            detail(id) {
                this.JAjax.postJson('title/content/' + id, {}, (res) => {
                    this.content =  res.data.detail  ? res.data.detail.content :  '' ;
                    this.title_id = res.data.id
                });
                this.JAjax.postJson('title/tags/' + id, {}, (res) => {
                    this.tags = res.data.tags || [];
                });

            },
            getlist() {
                let postdata = [];
                this.JAjax.postJson('title/lists', postdata, (res) => {
                    this.dataList = res.data || [];

                });
            },
            afresh_list() {
                this.getlist();
            },

        },
        mounted() {
            this.getlist();

        }
    };
</script>
<style>
    .center {
        text-align: center;
    }

    .ivu-page {
        display: inline-block;
    }
</style>
