import SimpleTable from "../components/SimpleTable/SimpleTable";
import Vue from 'vue';
import DeltaEvents from "./events";

export default class Delta extends DeltaEvents {
    constructor() {
        super();
        this.interval = 180000;
        this.deltaTable = undefined;
        this.today = undefined;
        this.createTable();
    }

    createTable() {
        let loadedData = {
            project: {name: 'Journal'},
            versions: {},//{"snapshotId": {'begin': 'name', 'end': 'id',}},
            deleteRoute: "#"
        };
        let delta = this;

        this.deltaTable = new Vue({
            el: '#deltaTable',
            render(h) {
                return h(SimpleTable, {
                    props: {
                        entity: delta,
                        filter: {
                            selector: {
                                route:  delta.getUrl('api_delta_object'),
                                callBack: delta.callBackGetJournal,
                            },
                            update: {
                                isUpdate: true,
                                interval: delta.interval,
                                callBack: delta.callBackAutoUpdate,
                            },
                            date: {
                                value: delta.getFormatCurrentDate(),
                                callBack: delta.callBackGetJournal,
                                format: "DD-MM-YYYY",
                                range: delta.getCurrentDate(),
                            },
                        },
                        headerTable: loadedData.project.name,
                        columnsTable: [
                            {name: 'begin', header: 'Начало', hasClasses: true},
                            {name: 'end', header: 'Конец', hasClasses: true},
                            {name: 'object', header: 'Объект', hasClasses: true},
                            {name: 'message', header: 'Параметр', hasClasses: true},
                            {name: 'notes', header: 'Сообщение', hasClasses: true},
                        ],
                        rowsTable: loadedData.versions,
                        deleteButton: {
                            route: loadedData.deleteRoute,
                            callBack: delta.callBackDelete,
                        },
                    }
                })
            },
            getComponent: function (root) {
                let component = undefined;
                root.$children.filter(
                    function (item, key) {
                        component = item;
                        return false;
                    }
                );
                return component;
            }
        });
    }

    getFormatCurrentDate() {
        let today = this.getCurrentDate();
        let dd = String(today.getDate()).padStart(2, '0');
        let mm = String(today.getMonth() + 1).padStart(2, '0');
        let yyyy = today.getFullYear();

        return dd + '-' + mm + '-' + yyyy;
    }

    getCurrentDate() {
        if (this.today === undefined) {
            this.today = new Date();
            this.today.setHours(0, 0, 0, 0);
        }

        return this.today;
    };


    callBackAutoUpdate(delta) {
        delta.beforeUpdate();
        let component = delta.deltaTable.$options.getComponent(delta.deltaTable);
        let date = component.getFilterDateValue();
        if (date === delta.getFormatCurrentDate()) {
            delta.callBackGetJournal();
        }
        delta.afterUpdate();
        component.setUnLock()
    }
    //
    // callBackDate(delta) {
    //     self.callBackGetJournal();
    // };

    callBackGetJournal(delta) {
        delta.beforeUpdate();
        let component = delta.deltaTable.$options.getComponent(delta.deltaTable);
        let dataFlow = component.getFilterSelectValue();
        let date = component.getFilterDateValue();
        if (undefined !== dataFlow) {
            let requestParam = {
                dataFlow: dataFlow,
                date: date
            };
            $.ajax({
                url: delta.getUrl('api_delta_journal', requestParam),
                type: 'GET',
                success: function (html) {
                  //  let delta = App.delta;
                    let component = delta.deltaTable.$options.getComponent(delta.deltaTable);
                    if (html.delta_data !== undefined) {
                        let dataLoad = delta.toComponentData(html.delta_data, requestParam.date);
                        component.updateRows(dataLoad);
                    }
                    delta.afterUpdate();
                    component.setUnLock()
                }
            });
        } else {
            delta.afterUpdate();
            component.setUnLock()
        }
    }

    toComponentData(journal, date) {

        let componentData = [];
        $.each(journal, function (keyJournal, valueJournal) {
            $.each(valueJournal.discreet_info, function (keyDiscreetInfo, valueDiscreetInfo) {
                componentData.push(componentData[keyDiscreetInfo] = {
                    begin: date + ' ' + valueDiscreetInfo.time,
                    end: date + ' ' + valueDiscreetInfo.time_end,
                    object: valueJournal.group.name,
                    message: valueJournal.name,
                    notes: valueJournal.additionalname,
                });
            });
        });

        return componentData;
    };

}

