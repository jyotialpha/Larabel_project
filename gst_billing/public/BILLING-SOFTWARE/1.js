// GST Calculate

function calculateNetAmount() {
  var totalAmount = parseFloat(
    document.getElementById("totalAmountInput").value
  );
  if (isNaN(totalAmount)) {
    totalAmount = 0;
  }

  var cgst = parseFloat(document.getElementById("cgst").value) || 0;
  var sgst = parseFloat(document.getElementById("sgst").value) || 0;
  var igst = parseFloat(document.getElementById("igst").value) || 0;

  var cgst1 = (cgst / 100) * totalAmount;
  var sgst1 = (sgst / 100) * totalAmount;
  var igst1 = (igst / 100) * totalAmount;

  var totalTax = ((cgst + sgst + igst) / 100) * totalAmount;
  var netAmount = totalAmount + totalTax;

  document.getElementById("totalAmountDisplay").value = totalAmount.toFixed(2);
  document.getElementById("tax").value = totalTax.toFixed(2);
  document.getElementById("netAmount").value = netAmount.toFixed(2);
  document.getElementById("cgst1").value = cgst1.toFixed(2);
  document.getElementById("sgst1").value = sgst1.toFixed(2);
  document.getElementById("igst1").value = igst1.toFixed(2);
}
