
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Aloha!</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
    .invoice-title{
        background-color: #03549e;
        color:white;
        font-weight: 700;
        padding-left: 0.25rem;
        padding-right: 0.25rem;
        width: fit-content;
        font-size: 1.125rem;
        line-height: 1.75rem;
        margin-bottom: 8px;
    }
    .invoice-dates{
        /* background: lightgray; */
    }
</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td valign="top"><img src="{{ public_path('/images/invoice-logo-3.png') }}" alt="Logo" class=""></td>
        <td align="right">
            <div class="flex justify-end w-full">
                <div class="bg-primary-600 px-1 text-lg text-white font-bold w-fit"></div>
            </div>
            <h3 class="invoice-title">FA- 0213</h3>
            <pre class="invoice-dates">
                Date de facturation: {{ $record->billing_date->format('d/m/Y') }}
                Date d'échéance: {{ $record->due_date->format('d/m/Y') }}
            </pre>
        </td>
    </tr>

  </table>



  <table width="100%">
    <tr>
        <td>
            <pre>
                <strong>Sarl Ultimate Market Technology</strong>
                Cyberparc de SIDI ABDELLAH RAHMANIA-ALGER
                RC : 17B 1012208-16/00
                NIF : 001716101220804
                Art : 16480102027
                <br />
                Téléphone: 0661485783/0559336237
                <br />
                Site: https://ultimatemarkettechnology.dz/
            </pre>
        </td>
        <td>
            <pre>
                <strong>Client</strong>
                <strong>Mrs. Audra D'Amore</strong>
                488 Jedidiah Junctions Apt. 925 North Brennanfort, KY 83981-9379
                Thompsonstad
                Nevada
                3923849
                Algérie
                RC: 18B 1012976 16/00
            </pre>
        </td>
    </tr>

  </table>

  <br/>

  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>#</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Unit Price $</th>
        <th>Total $</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
        <td>Playstation IV - Black</td>
        <td align="right">1</td>
        <td align="right">1400.00</td>
        <td align="right">1400.00</td>
      </tr>
      <tr>
          <th scope="row">1</th>
          <td>Metal Gear Solid - Phantom</td>
          <td align="right">1</td>
          <td align="right">105.00</td>
          <td align="right">105.00</td>
      </tr>
      <tr>
          <th scope="row">1</th>
          <td>Final Fantasy XV - Game</td>
          <td align="right">1</td>
          <td align="right">130.00</td>
          <td align="right">130.00</td>
      </tr>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td align="right">Subtotal $</td>
            <td align="right">1635.00</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td align="right">Tax $</td>
            <td align="right">294.3</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td align="right">Total $</td>
            <td align="right" class="gray">$ 1929.3</td>
        </tr>
    </tfoot>
  </table>

</body>
</html>


