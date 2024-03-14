# flask_app/app.py
from flask import Flask, jsonify
from flask_cors import CORS
import requests
import numpy as np
import pandas as pd
from skfuzzy import control as ctrl
from sklearn.model_selection import train_test_split
from sklearn.metrics import mean_squared_error

app = Flask(__name__)

CORS(app)

@app.route('/fuzzy', methods=['POST'])
def fuzzy_predict():
    laravel_api_url = 'http://127.0.0.1:8000/api/get-data'
    try:
        response = requests.get(laravel_api_url)
        response.raise_for_status()  # Membuat exception jika response status code bukan 200
        jagung_data = response.json()

        # Mengonversi data ke dalam format yang sesuai dengan yang diharapkan oleh model Fuzzy
        df = pd.DataFrame(jagung_data)
        df.dropna(inplace=True)

        # Pisahkan data menjadi data latih dan data uji
        X = df[['Area_Panen', 'Area_Lahan']]
        y = df['Produksi']

        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

        # Fuzzifikasi variabel
        luas_panen = ctrl.Antecedent(np.arange(0, 300, 1), 'area_panen')
        luas_tanam = ctrl.Antecedent(np.arange(0, 300, 1), 'area_lahan')
        produksi = ctrl.Consequent(np.arange(0, 15000, 1), 'produksi')

        # Fungsi keanggotaan untuk setiap variabel
        luas_panen.automf(3)
        luas_tanam.automf(3)
        produksi.automf(3)

        # Aturan fuzzy
        rule1 = ctrl.Rule(luas_panen['good'] & luas_tanam['good'], produksi['good'])
        rule2 = ctrl.Rule(luas_panen['average'] & luas_tanam['average'], produksi['average'])
        rule3 = ctrl.Rule(luas_panen['poor'] & luas_tanam['poor'], produksi['poor'])

        # Buat sistem kontrol fuzzy
        fuzzy_ctrl = ctrl.ControlSystem([rule1, rule2, rule3])
        fuzzy_model = ctrl.ControlSystemSimulation(fuzzy_ctrl)

        # Latih model
        for index, row in X_train.iterrows():
            fuzzy_model.input['area_panen'] = row['Area_Panen']
            fuzzy_model.input['area_lahan'] = row['Area_Lahan']
            fuzzy_model.compute()
            fuzzy_model.output['produksi']

        # Lakukan prediksi
        predictions = []
        for index, row in X_test.iterrows():
            fuzzy_model.input['area_panen'] = row['Area_Panen']
            fuzzy_model.input['area_lahan'] = row['Area_Lahan']
            fuzzy_model.compute()
            predictions.append(fuzzy_model.output['produksi'])

        # Evaluasi model
        mse = mean_squared_error(y_test, predictions)
        print("Mean Squared Error:", mse)

        # Plot hasil prediksi
        tahun_test = X_test.index

        hasil_prediksi = []
        for tahun, prediksi in zip(tahun_test, predictions):
            hasil_prediksi.append({"Tahun": tahun, "Prediksi": round(prediksi, 2)})

        return jsonify({"Hasil_Prediksi": hasil_prediksi}), 200

    except Exception as e:
        print("Error occurred while fetching or processing data:", e)
        return jsonify({"message": "Error occurred while fetching or processing data"}), 500

if __name__ == '__main__':
    app.run(debug=True)
