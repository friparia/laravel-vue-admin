<template lang="pug">
section
  el-col.toolbar(:span="24")
    el-form
      el-form-item
        template(v-for="action in singleActions")
          el-button(type="primary", @click="handleSingle(action)") {{ action.description }}
  template
    el-table(:data="data")
      el-table-column(v-for="field in listFields", :prop="field.name", :label="field.description")
      el-table-column(inline-template, :context="_self", label="操作", width="150", v-if="eachActions")
        span
          el-button(v-for="action in eachActions", @click="handleEach(action, row)") {{ action.description }}
  el-col.toolbar(:span="24", style="padding-bottom:10px;")
  el-pagination(layout="prev, pager, next", :page-size="page.per_page", :total="page.total", style="float:right;", @current-change="handleCurrentChange")
  el-dialog(:title="form.title", v-model="form.visible")
    el-form(:model="form", label-width="80px", :rules="form.rules", ref="form")
      template(v-for="fields in formFields")
        el-form-item(:label="field.description", :prop="field.name")
    .dialog-footer(slot="footer")
      el-button(@click.native="form.visible = false") 取消
      el-button(type="primary", @click.native="submit", :loading="form.loading") 提交

</template>

<script>
export default {
  name: 'List',
  data() {
    return {
      page: {
        current_page: 1,
        from: 0,
        last_page: 1,
        next_page_url: null,
        per_page: 1,
        prev_page_url: null,
        to: 1,
        total: 0,
      },
      form: {
        title: "",
        visible: false,
        loading: false,
        rules: {
        },
      },
      data: [],
      actions: [],
      name: this.$route.name,
      listFields: [],
      formFields: [],
      singleActions: [],
      eachActions: [],
    };
  },
  created() {
    this.$http.get('/api/' + this.name + '/configuration').then((res) => {
      let singleActions = [];
      let eachActions = [];
      res.body.actions.forEach((action) => {
        if(action.is_single){
          singleActions.push(action);
        }
        if(action.is_each){
          eachActions.push(action);
        }
      });
      this.listFields = res.body.listFields;
      this.singleActions = singleActions;
      this.eachActions = eachActions;
    });
    this.getData();
  },
  methods: {
    handleEach(action, obj){
      if(action.type == 'url'){
        this.$router.push('/' + this.name + '/' + action.name + '/' + obj.id);
      }
      if(action.type == 'modal'){
        this.form.visible = true;
      }
    },
    handleSingle(action){
      if(action.type == 'url'){
        this.$router.push('/' + this.name + '/' + action.name);
      }
      if(action.type == 'modal'){
        this.form.visible = true;
      }
    },
    handleCurrentChange(page){
      this.getData(page);
    },
    submit(){
      console.log("submit");
    },
    getData(page = 1){
      this.$http.get('/api/' + this.name + "?page=" + page).then((res) => {
        this.data = res.body.data.data
        this.page = res.body.data
      });
    },
  },
};
</script>
 
