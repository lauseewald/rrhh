<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="row">
        <h1>Sistema de Nóminas de Empleados</h1>
      </div>
      <br />
      <div class="col-md-8">
        <form @submit.prevent v-if="newEvent.event_name">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <b><label for="event_name">Nombre del Evento</label></b>
                <br />
                <label v-text="newEvent.event_name"></label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <b><label for="start_date">Fecha de Inicio</label></b>
                <br />
                <label v-text="newEvent.start_date"></label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <b><label for="end_date">Fecha de Finalización</label></b>
                <br />
                <label v-text="newEvent.end_date"></label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-8">
        <Fullcalendar :options="calendarOptions" />
      </div>
    </div>
  </div>
</template>

<script>
import Fullcalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

export default {
  components: {
    Fullcalendar,
  },
  data() {
    return {
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        events: "",
        locale: "es",
        eventClick: this.showEvent,
        addingMode: true,
      },

      newEvent: {
        event_name: "",
        start_date: "",
        start_time: "",
        end_time: "",
        end_date: "",
      },

      indexToUpdate: "",
    };
  },
  created() {
    this.getEvents();
  },
  methods: {
    addNewEvent() {
      axios
        .post("/api/calendar", {
          ...this.newEvent,
        })
        .then((data) => {
          this.getEvents(); // update our list of events
          this.resetForm(); // clear newEvent properties (e.g. title, start_date and end_date)
        })
        .catch((err) =>
          console.log("Unable to add new event!", err.response.data)
        );
    },
    handleDateClick: function (arg) {
      alert("date click! " + arg.dateStr);
      console.log("show");
      this.calendarOptions.addingMode = false;
      const { id, title, start, end } = this.calendarOptions.events.find(
        (event) => event.id === +arg.event.id
      );
      this.indexToUpdate = id;
      this.newEvent = {
        event_name: title,
        start_date: start,
        end_date: end,
      };
    },
    showEvent(arg) {
      console.log("show");
      this.calendarOptions.addingMode = false;
      const { id, title, start, end } = this.calendarOptions.events.find(
        (event) => event.id === +arg.event.id
      );
      this.indexToUpdate = id;
      this.newEvent = {
        event_name: title,
        start_date: start,
        end_date: end
        //end_time: end.slice(-8),
        //start_time: start.slice(-8),
      };
    },
    updateEvent() {
      axios
        .put("/api/calendar/" + this.indexToUpdate, {
          ...this.newEvent,
        })
        .then((resp) => {
          this.resetForm();
          this.getEvents();
          this.calendarOptions.addingMode = !this.calendarOptions.addingMode;
        })
        .catch((err) =>
          console.log("Unable to update event!", err.response.data)
        );
    },
    deleteEvent() {
      axios
        .delete("/api/calendar/" + this.indexToUpdate)
        .then((resp) => {
          this.resetForm();
          this.getEvents();
          this.calendarOptions.addingMode = !this.calendarOptions.addingMode;
        })
        .catch((err) =>
          console.log("Unable to delete event!", err.response.data)
        );
    },
    getEvents() {
      let me = this;
      var url = "/evento/home";
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.arrayEvento = respuesta.eventos.data;
          console.log(respuesta.eventos.data);
        })
        .catch(function (error) {
          console.log(error);
        });
      axios
        .get("/api/calendar")
        .then(function (response) {
          let respuesta = response.data;
          var events = respuesta.data;

          me.calendarOptions.events = events.concat(
            me.arrayEvento
          );
          console.log(me.calendarOptions.events);
        })
        //.then(resp => (this.events = resp.data.data))

        .catch(function (error) {
          console.log(error);
        });
    },
    resetForm() {
      Object.keys(this.newEvent).forEach((key) => {
        return (this.newEvent[key] = "");
      });
    },
  },
  watch: {
    indexToUpdate() {
      return this.indexToUpdate;
    },
  },
};
</script>

<style lang="css">
@import "~@fullcalendar/core/main.css";
@import "~@fullcalendar/daygrid/main.css";
.fc-title {
  color: #fff;
}
.fc-title:hover {
  cursor: pointer;
}
</style>
