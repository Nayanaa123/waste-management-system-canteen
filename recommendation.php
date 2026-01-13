<?php
function getWasteTips($food, $plastic) {
    $tips = [];

    
    if ($food > 30) {
        $tips[] = "High food waste detected. Consider reducing portion sizes in canteen meals.";
        $tips[] = "Start a food donation drive for leftover edible food.";
    } elseif ($food > 10) {
        $tips[] = "Moderate food waste. Encourage students to take only what they can eat.";
    } else {
        $tips[] = "Excellent! Food waste is minimal. Keep monitoring portion control.";
    }

    
    if ($plastic > 20) {
        $tips[] = "High plastic usage. Switch to biodegradable plates and cups.";
        $tips[] = "Encourage students to bring reusable bottles.";
    } elseif ($plastic > 5) {
        $tips[] = "Moderate plastic waste. Try organizing a 'Plastic Free Week' campaign.";
    } else {
        $tips[] = "Great! Low plastic usage. Maintain eco-friendly habits.";
    }

    
    if ($food + $plastic > 50) {
        $tips[] = "Total waste is quite high. Consider a campus-wide waste audit.";
    }

    return $tips;
}
?>