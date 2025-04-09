from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from transformers import pipeline, AutoTokenizer, AutoModelForSeq2SeqLM
import re

app = FastAPI()

# Konfiguracja CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Inicjalizacja modelu językowego
try:
    tokenizer = AutoTokenizer.from_pretrained("google/flan-t5-large")
    model = AutoModelForSeq2SeqLM.from_pretrained("google/flan-t5-large")
    generator = pipeline("text2text-generation", model=model, tokenizer=tokenizer)
except Exception as e:
    print("Błąd ładowania modelu:", e)
    generator = None

# Schemat danych wejściowych
class OfferData(BaseModel):
    name: str
    description: str
    tasks: list[str]
    expectancies: list[str]

@app.get("/")
def root():
    return {"message": "API działa. Użyj POST /generate_questions_ml"}

@app.post("/generate_questions_ml")
def generate_questions_ml(data: OfferData):
    if not generator:
        return {"questions": ["Model ML nie został poprawnie załadowany."]}

    joined_tasks = ', '.join(data.tasks)
    joined_expectancies = ', '.join(data.expectancies)

    programming_keywords = [
        "python", "java", "c++", "c#", "php", "javascript", "typescript",
        "ruby", "golang", "programist", "developer"
    ]
    is_programming = any(keyword in data.name.lower() or keyword in data.description.lower() for keyword in programming_keywords)

    if is_programming:
        prompt = (
            f"Job title: {data.name}\n"
            f"Tasks: {joined_tasks}\n"
            f"Requirements: {joined_expectancies}\n\n"
            f"Generate exactly 3 technical interview questions for a {data.name}.\n"
            f"The questions must be related to core knowledge required for this position.\n"
            f"If the role is programming-related, focus on syntax, built-in functions, libraries (like Django, NumPy), performance, and best practices.\n"
            f"Each question must start with a hyphen (-).\n"
            f"Do not repeat the example. Only output new questions.\n"
            f"Example:\n"
            f"- What is the difference between deep copy and shallow copy in Python?\n"
            f"- How does list comprehension work in Python?\n"
            f"- What are Python decorators used for?\n"
            f"Now generate 3 *different* questions, each starting with a hyphen (-), on a new line:"
        )
    else:
        prompt = (
            f"Job title: {data.name}\n"
            f"Tasks: {joined_tasks}\n"
            f"Requirements: {joined_expectancies}\n\n"
            f"Generate exactly 3 different technical interview questions for a {data.name}.\n"
            f"The questions must assess practical knowledge, field procedures, diagnostics, tool usage, or safety protocols.\n"
            f"Do not ask about interviews, recruitment, soft skills, or customers.\n"
            f"Each question must start with a hyphen (-), and each must appear on a new line.\n"
            f"Example:\n"
            f"- How do you test for a faulty thermal fuse in an industrial power supply?\n"
            f"- What diagnostic steps are used to identify overheating in a transformer station?\n"
            f"- What PPE is mandatory when working inside high-voltage substations?\n"
            f"Now generate 3 new and different technical questions:"
        )

    try:
        print("PROMPT:", prompt)

        result = generator(
            prompt,
            max_new_tokens=200,
            num_return_sequences=5,
            do_sample=True,
            temperature=0.7,
            top_k=50,
            top_p=0.95
        )

        print("RAW RESULT:", result)

        # Lepsze wyciąganie pytań
        all_text = ' '.join([r['generated_text'] for r in result])
        sentences = re.findall(r"- .*?\?|.*?\?", all_text)
        questions = [s.strip().replace("–", "-") for s in sentences if len(s.strip()) > 10]
        questions = list(dict.fromkeys(questions))[:3]  # usuń duplikaty i ogranicz do 3

        if not questions:
            questions = ["Nie udało się wygenerować pytań."]
    except Exception as e:
        questions = [f"Błąd generowania: {str(e)}"]

    return {"questions": questions}
