import {getJsonCardsArray} from "./session.js";

$(document).ready(function () {

        let cardOptionSelector = $("#assign-card");

        const cardsJsonArray = getJsonCardsArray();

        console.log(cardsJsonArray)

        let cardNullOption = `\t<option value=\"NULL\"> </option>\n`;
        cardOptionSelector.append(cardNullOption);

        // Initialize empty list of tasks for each of the user's cards
        for(var i = 0; i < cardsJsonArray.length; i++) {
                let card = cardsJsonArray[i];
                let cardOptionHTML = `\t<option value=\"${card["name"]}\"> ${card["name"]} </option>\n`;
                cardOptionSelector.append(cardOptionHTML);
        }
});