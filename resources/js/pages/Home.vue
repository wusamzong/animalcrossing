<template>
  <div class="container-xl px-1 pt-3">
    <h2>你好！</h2>
    <p>
      現在是{{dateValues[0]}}月{{dateValues[1]}}日 {{day[dateValues[2]]}}
      {{dateValues[3]}}:{{dateValues[4]}}
    </p>

    <p>
      現在大頭菜最高價在
      <span class="text-danger">{{compare[0]}}</span>的島，
      價格是
      <span class="text-danger">{{compare[1]}}</span>元
    </p>

    <div v-for="(user,index) in data" :key="index">
      <div class="d-flex justify-content-between">
        <h2>{{user.username}}</h2>
        <modal
          v-if="canEdit(user.username,index)"
          :price="user.price"
          @editPriceData="updatePrice"
        />
      </div>

      <div class="tableSize col-12">
        <table class="table table-hover tableSize">
          <thead class="bg-AC text-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">周日</th>
              <th scope="col">周一</th>
              <th scope="col">周二</th>
              <th scope="col">周三</th>
              <th scope="col">周四</th>
              <th scope="col">周五</th>
              <th scope="col">周六</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">AM</th>
              <td v-for="index in 7" :key="index">{{user.price[index-1]}}</td>
            </tr>
            <tr>
              <th scope="row">PM</th>
              <td v-for="index in 7" :key="index">{{user.price[index+6]}}</td>
            </tr>
          </tbody>
        </table>
        <p>develop by Sam</p>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import modal from "../components/modal.vue";
export default {
  name: "Home",
  props: ["app"],
  components: {
    modal,
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
    var dateValues = [
      date.getMonth() + 1,
      date.getDate(),
      date.getDay(),
      date.getHours(),
      date.getMinutes(),
    ];
    var priceID = 7 * Math.floor(date.getHours() / 12) + date.getDay();
    return {
      frontendUserID: -1,
      data: [],
      dateValues,
      day,
      inputPrice: "",

      isEdit: false,
      priceID,
      compare: [],
    };
  },
  methods: {
    /*
    getCookie(name) {
      console.log(this.$cookie.get(name));
    },
    setCookie() {
      this.$cookie.set('test', 'Hello world!', 60);
    },
    deleteCookie(){
      this.$cookie.delete('test') 
    },*/
    findHighest(data) {
      let max = [-1, -1];
      let index = 0;
      for (let value of data) {
        if (value.price[this.priceID] >= max)
          max = [index, value.price[this.priceID]];
        index++;
      }
      this.compare = [this.data[max[0]].username, max[1]];
    },
    getPrice() {
      this.app.req
        .get("api/auth/turnip/getPrice")
        .then((response) => {
          this.data = response.data.data;
          this.turnStrToInt(this.data);
          this.findHighest(this.data); //id,username,price
        })
        .catch((err) => {
          this.errors.push(err.response.data.error);
        });
    },
    turnStrToInt(data) {
      for (let value of data) {
        value.price = value.price.split("-");
      }
    },
    turnIntToStr(data) {
      this.inputPrice = data.join("-");
    },
    updatePrice(priceID) {
      //console.log(priceID);
      this.turnIntToStr(this.data[this.frontendUserID].price);
      const data = {
        id: this.data[this.frontendUserID].id,
        price: this.inputPrice,
      };

      this.app.req
        .put("api/auth/turnip/updatePrice", data)
        .then((response) => {
          this.inputPrice = "";
        })
        .catch((err) => {
          this.errors.push(err);
        });
    },

    Editing(select, thisUser, thisIndex) {
      if (select[0] === thisUser && select[1] === thisIndex) {
        return true;
      }
      return false;
    },
    canEdit(username, index) {
      if (this.app.user) {
        if (this.app.user.username === username) {
          this.frontendUserID = index;
          return true;
        }
      }
      return false;
    },
  },
  mounted() {
    this.getPrice();
  },
};
</script>
<style scoped>

.tableSize {
  width: 100%;
  overflow-x: auto;
}
</style>