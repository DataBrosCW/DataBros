@extends('layout.dashboard')

@section('dashboard-content')

    <div class="container">

        @if($followedProducts)
            <div class="header-databros pt-md-3 text-center mx-auto">
                <h1>Followed Products</h1>
            </div>

            @if(count($followedProducts)>0)

                <h3 class="mt-5 mb-3">Products you follow</h3>
                <div class="card-deck">
                    @foreach($followedProducts as $product)
                        <div class="col-sm-4 col-12">
                            <div class="card" style="width: 18rem;">
                                <div class="img-header" style="background-image: url({{$product->img}})"></div>
                                <div class="card-body">
                                    <h5 class="card-title">{{$product->title}}</h5>
                                </div>
                                <div class="card-footer">
                                    <a href="/products/{{$product->id}}"class="btn btn-primary btn-block">Buy ${{$product->price}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @endif

        @else
            <div class="header-databros pt-md-3 text-center mx-auto">
                <h1>Followed Products</h1>
            </div>
            <p>You currently don't follow any product.</p>
        @endif

        <h3 class="mt-5 mb-3">Because you searched for: iPhone X</h3>
        <div class="card-deck">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" style="height: 150px;"
                     src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw8QEhUQEBAPEhAPEA8PDw8QEBAPDg8OFRIWFhYRFRYYHiggGRolGxUVITEhJSkrLi4uFx8zOjUsNygtLisBCgoKDg0OFxAQGzcdHR0uKy0rLTc3LzUvNS8rLSstLS4tKzcrKys3LS0tLS4tNSsyKy8tLSsrLSstLSs3MS0rK//AABEIAM0A9QMBIgACEQEDEQH/xAAcAAEAAQUBAQAAAAAAAAAAAAAABwMEBQYIAgH/xABREAABAwIBBAoNCQUFCQAAAAABAAIDBBEFBxIhMQYTMzRBUXN0s7QUIjJTYXFygZKTsbLRFyNSVHWRobXTFSRCwdJFYmSDpCU1RFWChKKlw//EABsBAQACAwEBAAAAAAAAAAAAAAABBAIDBQYH/8QALxEBAAICAQIDBQcFAAAAAAAAAAECAxEEEkEFITETIlGBsQYjMjM0odEUJHGR8P/aAAwDAQACEQMRAD8AnFERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQFquNbPqCmeYs/bZGHNkEbmZsbuEOc4i5GohucRwgK62cVz4aUiNxZJM7aWvF7sGa57yDwOzGPAPA4grniqkY0udoZGzQLC9hezWtHCT8TwKRMzsqlLwNZbwuqAfwhK+fKnT/QZ6dT+goSo8SikcGDbGud3IeG2efogg6Dxe1ZONNCXPlRp/oM9Op/QX35T4O9s9Op/QUUsCrNCnQlD5ToO9s9Op/QT5ToO9s9Op/QUaAL7mpoST8qEHe2enU/oKvT5UKEkB4c0HW5pDg0ceY7Ne7/pa4qKKkta0udqaLlalPMXuLjrJ0eAcACjQ62oqyKdjZYXtkjkGcx7CHNcPAQq6iLIvibgdrzvm584FnAKpoLg9o4C5jH53ks8N5dUC0xTEI6aJ88pOZG3OOa0ueTewa1o0lxJAA4SQtQ2K5S4a+Uxikq4Wbcads8jWGLbwL7U8tJzHHzi9he5CzGz/eMnKUp/1MSivJ3UPZSVUjGbY+PEhKyPODdse2WJwbnHQLkAXKCdkVOnkz2tda2c1rrcVxey+VU4jY6R2qNjnm2uzQSfYgxeyDZPR0IHZEoa5wu2MEbY4cdiQANB0ki9lrD8q1F/CLj+8XsP3FiinZO+Ssq3iVxJd87O5p0uBcWxxNOsMszO9EcAVBmE0w0bTH52gn7ytN89a26XV4XhGbk09pExEdtpd+VSk+i31jv6F9+VKl+i31rv6FBuybAS5rH00Le1zhI2NoDiDazrDXw/etbGDVf1ao9TJ8FsraLRtV5PCy4Mk0mN679nS3ypUv0G+td/QnypUv0G+td/QuahhdQNdLP54pB/JeHUE31eYcfaSafwWzot8FOZiPV0v8qdL9BvrXf0L4cqlL9BvrXf0Lmd9BNfRDKBxZj9H4LZdjeAtcx7p9oYRdwExGeQBoa0cZK2Y8Frzr0Y2yRWNp2iyq0P8YLR/dL3n3APvIC2vAsfpa1pfTytfm2z2gjPYTxj79I0aCue6fY1RSFzeyKSMNYxwe9ksec5wN2NzQTcaL+NXWT6vfR1Qs4/NFhuTpkpZDmmN3GQ4NA8ofRFssvHtjjfrDGmaLzp0aiIq7aIiICIiDUco5dtUWaAbzHOubWbmO0jRpPg8K5zxo/M/wCey/q5F0flC3KPlD7pXN2Obj/nM6N6nsLFu2Nkhz2OZd8bmZzCzObnjSLgXHhW3R/zPtWHx7ZZU4g6mbOyJgp3MDNraQXOLmAk3OjUNA+FsvGfafakTM+ouWKs1W7CqzSpQrtXtUgVb4jWCJhd/FqaONyDFbIay52pp0N0v8LuAeZYZfXOJNzpJ0k8ZXxEpPyOl22w6AW9kz3N9IIpZLWHDrKnJQbkgJD4SPrcg8xp3D+anJYyNcyg37BktYnPprAmwJ7Ij4VEmT98gpaqzWZnZ13uLyHtfns0BubYjVpuFLmz/eMnKUvWI1E2wE2oaw8VeekjQTpQblHybPdCoY7fsaewBPY81gTYE7WdF+BV6Dco+TZ7oVvj5Ipprd6ePMRYoOdWXM7ydfY9DfxmG5V0AraPd5Ob0HQq6sq1se7zL3fg/wCix/P6y9sfZXMVQQrYBVtrIAJBAdpBIIBHGONWsdIhevET5SyuG4TJWybVCWBxa593khthbiB41YbKaRsErqfMa18Ls0uZch7DGwi99br5xvb+LwC1SB8sYD2GRh05r2lzLg6wHBYqvkc9xc9znOdrc4lzj4yda63FmZ7+UPnPj2D2WWdd2PkVElV5WnVY3NrC2k31K2crsuNjhVaVXwgnsoZoBdtdOQCbAuFbEQCeDTwq0aVd4BvweRT9dhVTmfkz8m/BXWSHS9Ke0b5DfYFVVGj3NnkM9gVZcZfEREBERBqmULco+UPuFc61lPtrCy9jdr2uN7B7bixtwEOP4LobKGTmRDgzpCR4QBb2lc/sKmBjqOglL2ulLQ2ItIDXte5xabhvak2GjhstgiVswqs1ylC6aVVa5WzXK/wmjdUSCJpAuCXOd3LGAXLig8hy1vFavbX6O5bob4eMrKY/UNjLo4354LnNa/VnMBtneda8iRERBKGR+2fDfV2XLwX09jPt+NlOKgzJF3UXPH9CVOaiRruz/eMnKUvWI1DuxOGSTC8RZCC6V9VK2Jre6dIXMDQPDeymLZ/vGTlKXrEajfJa0COUDhxGFx8e3R3UCY6FhbGwEWIjYCOIhouFQx23Y81+8yAaL9tmm342V8rDHt7yeR/MIOd4h8/Jzeg6FXgCtYB8/Jzeg6FXqzrXu9z4RP8AZ4/n9ZXWExNdNE1wBaZWAtOp3bDtT49XnVzh1UZNs25z5GbXtzgTe7mvYbt4iblui3dWVtTU0rhnxgktcLZp7cOGkOHxV3JHUuBaIWszrF5Y0MdIQ7x6s7TZthq8C2N2WazadzHbv6ef/f6X9MHPfLnzNfE+OYtAeHZwDHOZaO9482wOkC1rePCxULnl0m0ue2Fsd4o2PcZHkdo0gXNnWLidVgbWJCysJmcHksja43ErgA2R+jPNxfRe1zYC6xeI4VO432suGgB1wW20AAEnxBWeLbzmN6eT+0GOOitu8PVVNUR1UD3h7JJW0QL3R5r9TA8NJHa67G1rDQtXrd0f5b/eKzb6CrzmybVYwtjzScxrQ2JoLSbmxFm61icQpJozeVjmF5cbOFiTrOjzhX66ju8zSZWjVe4BvseRT9dhVmwK+wFv743yKfrsK08z8mfk3Yp+8h0pR7mzyGewKsrbDSTDGSbkxRknjOaFcrjLoiIgIiINPyidzD45PY1c+sK6DyiNOZEdFg6QHjuQCPYVzwwqYFy1yrNcrVrlUa5ShndjNKyaoYyTSztnOb9INaTm/fZSDij6SCJ000UO1wNL9zYc0DUG6NeoAeJRdhlaYZWSt0ljr2426iPOCV9yi7ITVZlPBcwttJK7Vnyfws0/R9p8CDAVeIvqpZKh+gyvuGDuY2gANaPELBeFaUMThcm44AP5q7RIiIgk/JDbOhve3Zcmrj7Hdb8bKclBmSLuoueP6Eqc1jI13Z/vGTlKXrEajjJh3EnP4emiUj7P94ycpS9YjUbZK3Z0cp4sSib5xNHdBNasMet2PLe+5utbXnW0fjZX6sMe3vJ5H8wg56p93k5vQdCr1WVPu8nN6DoSr1bq/he28J/SU+f1l7jme3uXObfXmuLb/cvbaqXvknrH/FULKowLG1nRmte8MnSyvNznOu7urEjO8BtwKwrquUXAkksRYjPdq0aNfgCyNCzQVjq+JWuF5y8j9oZjp6YYt9XNr22W/Htj7+1WlRI9/dOc62rOcXW8V/EFdSRqkYl1tQ8VTJpbxMV7hDLVjPDHT9dhVWhpc42V9LT7XXQjjgpz/r4lU5s6xTCxxrTbLE9k84ZuMXJR+6Fcq2w1pEMYNriKMG2kXzQrlcZ1BERAREQanlD3KPlD7hXOLSujsoe5R8o73CubmlZQhXa5VGuVuHL2HIKskuaL8PB41YEr3K+58AXhEiIiAiIglHI6AXw3+tTHzilepwUIZHO7h51P1V6m9RI13Z/vGTlKXrEajTJLuM32qzpolJez/eMnKUvWI1GeSXcpvtVnTRKBNyssbF6ea/eZT5wwkK9VnjW95uQm9woOe6Jl55Ob4f0JWRMStcJF55eb4f0JWYMazm2qw9V4Tm+5ivw39WPLF9aFXexeGtVe13a6mbwyC7LqnUUBPAtgwOh+aabaxdZB2HDiVvi5orDxXi1va5Zj4I/nw3wK1dh632ow4cSx8lB4F1cefcPLZsGpYfBsP7YaFT2TQ5mIU446WA/+wiW2YTR2Opa9s4bbEqcf4SD8wiVPmZOryW+HTXml2j3NnkM9gVZUaPc2eQz2BVlQXxERAREQanlD3KPlD7hXNbSulMoe5R8o73CuagsoHsFHOXi6IgRERIiIgIiIJSyOd3Dzqfqr1N6hDI53cPOp+qvU3qJGu7P94ycpS9YjUZ5Jdym+1WdNEpM2f7xk5Sl6xGo0yTblN9qRm/Bpmj0KBNqs8a3vNyE3uFXis8Z3vNyE3uFBAuDD5+Xm+H9CVnA1YTBB8/NzfDugKz4amadUh2fC768lrKxUWs0gcZV7K1fKFl5YxxyRj/yC5lsj0cX1WZSTh9KGsa3iaB9wV0YQvsOpVVbxS8fk96ZmWPngVhLTLMyBWz2Lo4rOZmx7W9FBZaNs7/3nT80h/MIlIcYso72d/wC86fmkH5jEsMs7Tir0wlyj3NnkM9gVZUaPc2eQz2BVlpbhERAREQanlD3KPlHe4VzUF0rlD3KPlD7hXNQUwCIikEREBERAREQSlkc7uHnU/VXqb1CGRzu4edT9VepvUSNd2f7xk5Sl6xGo0yS7jN9qs6aJSXs/3jJylL1iNRpkl3Gb7VZ00SgTarPGd7zchN7hV4rPGd7zchN7hQQRgQ+fm5vh3QFbG1iwGxtt6ibm+HdAVtzIFhyo+7qv8C+rSx8kSYfH89HykfvBZB9OveG0hMrNGpwP3LhzM9T0PtY6J/w3iJVCUhboX14XVp5Q81M+ai8qg4r1I5UXOVvHdpyY3q6jzZwf9pwc1g/MIlvpco/2Zn/aUHNYPzCJZWncNOtSmCj3NnkM9gVZUaPc2eQz2BVlgkREQEREGp5Q9yj5Q+4VzUF0rlE3GPlD7hXNQUwCIikEXxzgNa8iVvGg9ovIeDqK9ICIiCUsjndw86n6q9TeoQyN93Dzqfqr1N6xka7s/wB4ycpS9YjUaZJdxm+1WdNEpL2f7xk5Sl6xGo0yS7jN9qs6aJBNqs8Z3vNyE3uFXis8Z3vNyE3uFBCexFt6ibm+HdCVvlPT3Wj7Chepm5vh3QlSZRQLZkjeOGeG/TaVq2ivwK9w6gAOdZZGOnV1FFZc6OPHVtctyZ6dPjW2XiRV3K2mct8xpWr5yxtS+xVBz14rZe2VsZVrrk1K9OLdYlXc9aHstdfEoObQfmES3F8q0jZK6+Iw82g/MIlbrO67c3LGrpqo9zZ5DPYFWVGj3NnkM9gVZQxEREBERBqeUTcY+UPuFc1BdK5RNxj5R3uFc1BTAIiKR5dbh9hXwtB4PwK9FfABxIPgAHB+BXteWr0gIiIJSyOd3Dzqfqr1N6g/I33cPOp+qvU4LGRruz/eMnKUvWI1GmSXcZvtVnTRKS9n+8ZOUpesRqM8ku5TfarOmiQTcrPGd7zchN7hV4rPGd7zchN7hQQ3sEH71NzfDehKlegjUV7AB+9T83w3oSpZoQt8/ghrifelftavqL4VXlteJCsfVyWCvJnLA4rUWCrZbahb4+PqljaufSqBmVjNUaV4dOufF/N25w6qu3zLUcadfEIubwdfiWcfMtcr3Xr4uQg6/Euxg88UvP8AKjWRPFHubPIZ7Aqyo0e5s8hnsCrLJoEREBERBqOUZwEMfKOA8JzDoXNgXSmUiMGCMkXtM6xIvmnaZHZ3g7ki/hXNjm2JB1gkHxhTA+IiKQKIiD5ZfURAREQShkcd85CP8TNYf9rIpxUH5HIrywnNBInmde2lrDTytJHgzg0ecKcFjI13Z/vGTlKbrEajPJKRtUwuLnFWEDhI26JSXlBANDICLgvpgQdRBqI9CjDJNAwxyvLGl7MUja15aC5rdui7UHWBpKCclZY0f3ebkJvcKvVZ40zOp5ha94Jha173YdFkEP5P98z83w3oHLfscrJIoAYyWl7wwuGtosToPBe2taHsEaG1lRHouKeisOMRh8TreJzbKUIIWvbmvaHNOsHUVumfchhEe9LD4HVyNqGxB0jo5GBzhI7PIJjz84cWnR51tbirShw6CG5iYGk6CblzrcVydSrSuVa06b6xta1ctgtSxmq1rO4nPYLSMYqda52e7t8DBuVs6fSqFHBHUOl26tZTbW4MiY5wbnXv2+ki40firDsnSvj2xvN3NBPHpH32WnBMRbzh1+RxbXpqs6XFDVOcwFxudIvx2OtY+Z/79GTqEEFydQHZ0Svg8AWGgDUBqssY0B9ZqDgyGmD22uCDVseWkeQx2hdnFaOjTzvP41qR1S6EpNzZ5DPYFWXiFma0N4mgfcF7UuWIiICIiDH49hbauB8DiW54Ba8aTHI0hzHgcNnAG3Dq1Fc6bJ9iNbTSu22INu7Q/Pa2CQk643vIBv8ARvnC+pdNr4Qg5O/YtX9Xm8zCR94T9i1f1eb1bl1UaGHvUXq2/BfOwIO8xerZ8FOxyt+xav6vN6tyfsWr+rzercuqewIO8xerZ8F7FLENUbPQamxyn+xav6vN6tyfsWr+rzercuqjQwnXFF6DfgvnYEHeYvVs+CbHK37Fq/q83q3KpT4DVPcGCI550iO7TMR/diBz3eYLqXsCDvMXq2fBVooWs0Na1o4mgNH4JsaPkw2Iy0Ue3VIDZns2uOEEONPCSHOznDQXvLWk20DNaBwk72iKBgdnULn0UoY1zi0wSFrGlzyyOZj32aNJOa1xsNJsojySYpC8vpYy588uJCoa1rHkCla9j3TOdazW2YRp03LRwqel4ZG0EkNALjdxAALjxnjQe0REEKbNNieIUM/ZdAC5sbnvgc2xzGPN308zXWBjOu5OvTe5ShykYs0WfhQc4a3AVbGHwj5t1/MSprVF9JE43McZJ1ksaSU2InGUzFP+VN9Kq/SQ5RsUP9mR+d1Uf/ipW7Ch71F6DfgnYUPeovQb8FE1iU9UofqNnGKP/s6AeNs7vbCsVU7IMUf/AMDSjx073e2FTu2ljGqNg8TWhHUsR1xxnxsaVhOGk9m6nJyU9J/aP4c7VlXiUls6jhFr22uCWInx5sQurXOxAf8ACn0an9NdI9hQ96i9BvwTsKHvUXoN+Cx/p8frpZr4pyqxqL/tH8OapJsT1NpHAnQHGOoLAfCXNa0echb3k02DVW2NqatpY1rxO7Ptts84Fm6BoDGjRoJBBOvO7WXY6aNpu1jGnjDWg/gqq2VpFfRoz8vNn17S29CIiyVhERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQf//Z"
                     alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">iPhone X</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's content.</p>
                    <a href="/products/example" class="btn btn-primary btn-block">Buy 700$</a>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" style="height: 150px;"
                     src="data:image/jpeg;base64,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"
                     alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Samsung S12</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's content.</p>
                    <a href="/products/example" class="btn btn-primary btn-block">Buy 12$</a>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" style="height: 150px;"
                     src="https://store.storeimages.cdn-apple.com/4974/as-images.apple.com/is/image/AppleInc/aos/published/images/i/pa/ipad/pro/ipad-pro-select-scene2-201706-i1?wid=474&hei=385&fmt=jpeg&qlt=95&op_sharpen=0&resMode=bicub&op_usm=0.5,0.5,0,0&iccEmbed=0&layer=comp&.v=1505500524375"
                     alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">iPad</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's content.</p>
                    <a href="/products/example" class="btn btn-primary btn-block">Buy 500$</a>
                </div>
            </div>
        </div>
    </div>




@endsection