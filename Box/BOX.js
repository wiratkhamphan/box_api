$('#action-button').click(() => {
    console.log('Clicked!');
    $.ajax({
        url: "http://localhost:8080/Box",
        data: {
            format: 'json'
        },
        error(xhr, status, error) {
            console.error("Error details:", status, error);
            $('#info').html('<p>An error has occurred</p>');
        },
        dataType: 'json',
        success(data) {
            // Assuming you want to display the information from all items in the array
            $('#info').empty(); // Clear previous content

            // Loop through each item in the array
            data.forEach(item => {
                let title = $('<h1>').text(item.Box);
                let description = $('<p>').text(item.Appress);

                // Append title and description to the '#info' div
                $('#info').append(title).append(description);
            });
        },
        type: 'GET'
    });
});
