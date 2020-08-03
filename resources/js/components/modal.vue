<template>
  <div class="container-xl">
    <!-- Button trigger modal 
    <button
      type="button"
      class="btn btn-primary"
      data-toggle="modal"
      data-target="#exampleModalCenter"
    >Launch demo modal</button>-->
    <img
      :src="editImg"
      height="30px"
      data-toggle="modal"
      data-target="#exampleModalCenter"
      alt="編輯報價系統"
    />
    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModalCenter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">更新資料</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="row mx-2 mb-3">
              <select class="col form-control mx-1" v-model="dateValues[0]">
                <option>星期日</option>
                <option>星期一</option>
                <option>星期二</option>
                <option>星期三</option>
                <option>星期四</option>
                <option>星期五</option>
                <option>星期六</option>
              </select>
              <select class="col form-control mx-2 mb-2" v-model="dateValues[1]">
                <option>上午</option>
                <option>下午</option>
              </select>
              <input
                type="text"
                class="form-control mx-1"
                placeholder="選擇輸入菜價"
                v-model.trim="price[priceID]"
              />
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="confirmHandler(priceID)">確認</button>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    price: {
      type: Array,
      require: true,
    },
  },
  data() {
    const date = new Date();
    let day = [
      "星期日",
      "星期一",
      "星期二",
      "星期三",
      "星期四",
      "星期五",
      "星期六",
    ];
    let sessions = ["上午", "下午"];
    var dateValues = [
      day[date.getDay()], //今天是星期幾
      sessions[parseInt(date.getHours() / 12)], //是上午還是下午
    ];
    var priceID = 7 * parseInt(date.getHours() / 12) + date.getDay();
    let mapDay = new Map([
      ['星期日',0],
      ['星期一',1],
      ['星期二',2],
      ['星期三',3],
      ['星期四',4],
      ['星期五',5],
      ['星期六',6],
    ]);
    let mapSessions = new Map([
      ['上午',0]
      ,['下午',1]
    ]);
    return {
      editImg: "/InternetForum/public/images/edit.png",
      dateValues,
      priceID,
      mapDay,
      mapSessions,
    };
  },
  watch:{
    dateValues: function(val){
      this.priceID=7*this.mapSessions.get(val[1])+this.mapDay.get(val[0]);
    },
    deep:true
  },
  methods: {
    confirmHandler(priceID) {
      this.$emit("editPriceData", priceID);
    },
  },
};
</script>
